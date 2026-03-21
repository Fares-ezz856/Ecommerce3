@extends('layouts.admin')

@section('page-title', __('Invoice Details') . ': ' . $invoice->invoice_number)

@section('styles')
<style>
    @media print {
        .no-print { display: none !important; }
        .sidebar { display: none !important; }
        .top-navbar { display: none !important; }
        .main-content { margin: 0 !important; padding: 0 !important; }
        .card { box-shadow: none !important; border: 1px solid #eee; }
    }
</style>
@endsection

@section('content')
<div class="no-print" style="display: flex; gap: 1rem; margin-bottom: 2rem;">
    <button onclick="window.print()" style="padding: 10px 20px; background: #475569; color: white; border: none; border-radius: 8px; cursor: pointer;">
        <i class="fas fa-print"></i> {{ __('Print Invoice') }}
    </button>
    
    @if($invoice->status != 'paid')
        <a href="{{ route('stripe.checkout', $invoice->id) }}" style="padding: 10px 20px; background: #6366f1; color: white; border: none; border-radius: 8px; text-decoration: none; font-weight: 600;">
            <i class="fab fa-stripe"></i> {{ __('Pay with Stripe') }}
        </a>
    @endif
    
    <a href="{{ route('admin.invoices.index') }}" style="padding: 10px 20px; background: white; color: #64748b; border: 1px solid #e2e8f0; border-radius: 8px; text-decoration: none;">{{ __('Back to List') }}</a>
</div>

<div class="card" style="background: white; padding: 4rem; border-radius: 12px; box-shadow: var(--shadow); color: #1e293b;">
    <div style="display: flex; justify-content: space-between; margin-bottom: 4rem;">
        <div>
            <h1 style="color: var(--primary); font-weight: 800; margin: 0;">{{ __('INVOICE') }}</h1>
            <p style="color: #64748b; font-family: monospace;">#{{ $invoice->invoice_number }}</p>
        </div>
        <div style="text-align: right;">
            <h3 style="margin: 0;">{{ config('app.name', 'ERP System') }}</h3>
            <p style="color: #64748b; margin: 0;">{{ __('Company Address Line 1') }}</p>
            <p style="color: #64748b; margin: 0;">{{ __('Contact') }}: +1 234 567 890</p>
        </div>
    </div>

    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 4rem; margin-bottom: 4rem;">
        <div>
            <h4 style="text-transform: uppercase; color: #94a3b8; font-size: 0.8rem; margin-bottom: 1rem;">{{ __('Billed To') }}</h4>
            <h3 style="margin: 0;">{{ $invoice->customer->name }}</h3>
            <p style="margin: 0; color: #475569;">{{ $invoice->customer->address }}</p>
            <p style="margin: 0; color: #475569;">{{ $invoice->customer->phone }}</p>
            <p style="margin: 0; color: #475569;">{{ $invoice->customer->email }}</p>
        </div>
        <div style="text-align: right;">
            <h4 style="text-transform: uppercase; color: #94a3b8; font-size: 0.8rem; margin-bottom: 1rem;">{{ __('Invoice Info') }}</h4>
            <p style="margin: 0;"><strong>{{ __('Date') }}:</strong> {{ $invoice->created_at->format('F d, Y') }}</p>
            <p style="margin: 0;"><strong>{{ __('Type') }}:</strong> {{ strtoupper(__($invoice->type)) }}</p>
            <p style="margin: 0;"><strong>{{ __('Payment') }}:</strong> {{ strtoupper(__($invoice->payment_method)) }}</p>
            <p style="margin: 0;"><strong>{{ __('Status') }}:</strong> 
                <span style="color: {{ $invoice->status == 'confirmed' ? '#059669' : '#d97706' }}; font-weight: 700;">
                    {{ strtoupper(__($invoice->status)) }}
                </span>
            </p>
        </div>
    </div>

    <table style="width: 100%; border-collapse: collapse; margin-bottom: 4rem;">
        <thead>
            <tr style="border-bottom: 2px solid #e2e8f0; text-align: left;">
                <th style="padding: 1rem 0;">{{ __('Item Description') }}</th>
                <th style="padding: 1rem 0; text-align: center;">{{ __('Qty') }}</th>
                <th style="padding: 1rem 0; text-align: right;">{{ __('Unit Price') }}</th>
                <th style="padding: 1rem 0; text-align: right;">{{ __('Subtotal') }}</th>
            </tr>
        </thead>
        <tbody>
            @foreach($invoice->items as $item)
            <tr style="border-bottom: 1px solid #f1f5f9;">
                <td style="padding: 1rem 0;">
                    <strong style="display: block;">{{ $item->product->name }}</strong>
                    <small style="color: #64748b;">Code: {{ $item->product->code }}</small>
                </td>
                <td style="padding: 1rem 0; text-align: center;">{{ $item->quantity }}</td>
                <td style="padding: 1rem 0; text-align: right;">${{ number_format($item->unit_price, 2) }}</td>
                <td style="padding: 1rem 0; text-align: right;">${{ number_format($item->subtotal, 2) }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div style="display: flex; justify-content: flex-end;">
        <div style="width: 300px;">
            <div style="display: flex; justify-content: space-between; padding: 0.5rem 0;">
                <span>{{ __('Subtotal') }}:</span>
                <span style="font-weight: 600;">${{ number_format($invoice->items->sum('subtotal'), 2) }}</span>
            </div>
            <div style="display: flex; justify-content: space-between; padding: 0.5rem 0; color: #ef4444;">
                <span>{{ __('Discount') }}:</span>
                <span>-${{ number_format($invoice->discount, 2) }}</span>
            </div>
            <div style="display: flex; justify-content: space-between; padding: 1.5rem 0; border-top: 2px solid #e2e8f0; margin-top: 1rem;">
                <span style="font-size: 1.2rem; font-weight: 800;">{{ __('Grand Total') }}:</span>
                <span style="font-size: 1.5rem; font-weight: 800; color: var(--primary);">${{ number_format($invoice->total_amount, 2) }}</span>
            </div>
        </div>
    </div>

    @if($invoice->status == 'confirmed')
    <div style="margin-top: 4rem; padding-top: 2rem; border-top: 1px dashed #e2e8f0; text-align: center; color: #94a3b8;">
        <p>{{ __('Thank you for your business. This invoice is electronically generated and confirmed.') }}</p>
    </div>
    @endif
</div>
@endsection
