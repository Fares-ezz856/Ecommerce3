<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use App\Models\Invoice;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminPaymentController extends Controller
{
    public function index()
    {
        $payments = Payment::with(['customer', 'invoice'])->latest()->paginate(20);
        return view('admin.payments.index', compact('payments'));
    }

    public function create(Request $request)
    {
        $customers = Customer::all();
        $invoices = [];
        if ($request->customer_id) {
            $invoices = Invoice::where('customer_id', $request->customer_id)
                               ->where('status', 'confirmed')
                               ->get();
        }
        return view('admin.payments.create', compact('customers', 'invoices'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'customer_id' => 'required|exists:customers,id',
            'invoice_id' => 'nullable|exists:invoices,id',
            'amount' => 'required|numeric|min:0.01',
            'payment_method' => 'required|string',
            'reference_number' => 'nullable|string',
            'payment_date' => 'required|date',
            'notes' => 'nullable|string'
        ]);

        return DB::transaction(function () use ($data) {
            $payment = Payment::create($data);

            // Deduct from Customer Balance
            $customer = Customer::find($data['customer_id']);
            $customer->decrement('balance', $data['amount']);

            return redirect()->route('admin.payments.index')->with('success', 'Payment recorded and customer balance updated');
        });
    }
}
