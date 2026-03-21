<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StripeController extends Controller
{
    public function checkout(Invoice $invoice)
    {
        $user = Auth::user();

        // Ensure user is billable
        if (!$user) {
            return redirect()->route('login');
        }

        return $user->checkout([
            config('cashier.payment_price_id') ?? 'price_placeholder' => 1,
        ], [
            'success_url' => route('stripe.success', $invoice->id) . '?session_id={CHECKOUT_SESSION_ID}',
            'cancel_url' => route('stripe.cancel', $invoice->id),
            'line_items' => [
                [
                    'price_data' => [
                        'currency' => 'usd',
                        'product_data' => [
                            'name' => "Invoice #{$invoice->invoice_number}",
                        ],
                        'unit_amount' => $invoice->total_amount * 100, // Amount in cents
                    ],
                    'quantity' => 1,
                ],
            ],
            'mode' => 'payment',
        ]);
    }

    public function success(Request $request, Invoice $invoice)
    {
        $session_id = $request->get('session_id');

        // Create a payment record
        Payment::create([
            'invoice_id' => $invoice->id,
            'customer_id' => $invoice->customer_id,
            'amount' => $invoice->total_amount,
            'payment_method' => 'stripe',
            'reference_number' => $session_id,
            'payment_date' => now(),
            'notes' => 'Stripe Payment Success',
        ]);

        // Update invoice status if needed
        $invoice->update(['status' => 'paid']);

        return view('admin.stripe.success', compact('invoice'));
    }

    public function cancel(Invoice $invoice)
    {
        return view('admin.stripe.cancel', compact('invoice'));
    }

    public function orderCheckout(\App\Models\Order $order)
    {
        $user = Auth::user();

        if (!$user) {
            return redirect()->route('login');
        }

        return $user->checkout([
            config('cashier.payment_price_id') ?? 'price_placeholder' => 1,
        ], [
            'success_url' => route('stripe.order.success', $order->id) . '?session_id={CHECKOUT_SESSION_ID}',
            'cancel_url' => route('checkout.index'), // Return to checkout on cancel
            'line_items' => [
                [
                    'price_data' => [
                        'currency' => 'usd',
                        'product_data' => [
                            'name' => "Order #{$order->id}",
                        ],
                        'unit_amount' => $order->total_price * 100,
                    ],
                    'quantity' => 1,
                ],
            ],
            'mode' => 'payment',
        ]);
    }

    public function orderSuccess(Request $request, \App\Models\Order $order)
    {
        $session_id = $request->get('session_id');

        $order->update([
            'payment_status' => 'Paid',
        ]);

        // Optionally create a payment record in the ERP table if needed
        // For now, just mark the order as paid.

        return redirect()->route('orders.index')->with('success', 'Order paid and placed successfully!');
    }
}
