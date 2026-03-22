@extends('layouts.admin')

@section('page-title', 'Payment History')

@section('content')
<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;">
    <h2 style="font-weight: 700;">Collections & Payments</h2>
    <a href="{{ route('admin.payments.create') }}" style="background: var(--primary); color: white; padding: 10px 20px; border-radius: 8px; text-decoration: none;">
        <i class="fas fa-plus"></i> Record Payment
    </a>
</div>

<div class="table-card" style="background: white; border-radius: 12px; box-shadow: var(--shadow); overflow: hidden;">
    <table style="width: 100%; border-collapse: collapse;">
        <thead>
            <tr style="background: #f8fafc; text-align: left;">
                <th style="padding: 1rem 1.5rem; color: var(--text-muted); font-size: 0.8rem; text-transform: uppercase;">{{ __('Date') }}</th>
                <th style="padding: 1rem 1.5rem; color: var(--text-muted); font-size: 0.8rem; text-transform: uppercase;">{{ __('Customer') }}</th>
                <th style="padding: 1rem 1.5rem; color: var(--text-muted); font-size: 0.8rem; text-transform: uppercase;">{{ __('Invoice') }} #</th>
                <th style="padding: 1rem 1.5rem; color: var(--text-muted); font-size: 0.8rem; text-transform: uppercase;">{{ __('Amount') }}</th>
                <th style="padding: 1rem 1.5rem; color: var(--text-muted); font-size: 0.8rem; text-transform: uppercase;">{{ __('Method') }}</th>
                <th style="padding: 1rem 1.5rem; color: var(--text-muted); font-size: 0.8rem; text-transform: uppercase;">{{ __('Ref') }}</th>
            </tr>
        </thead>
        <tbody>
            @foreach($payments as $payment)
            <tr style="border-bottom: 1px solid #edf2f7;">
                <td style="padding: 1rem 1.5rem; color: var(--text-muted);">{{ $payment->payment_date }}</td>
                <td style="padding: 1rem 1.5rem; font-weight: 600;">{{ $payment->customer->name }}</td>
                <td style="padding: 1rem 1.5rem; font-family: monospace;">{{ $payment->invoice->invoice_number ?? 'General Account' }}</td>
                <td style="padding: 1rem 1.5rem; font-weight: 700; color: #065f46;">${{ number_format($payment->amount, 2) }}</td>
                <td style="padding: 1rem 1.5rem;">
                    <span style="text-transform: capitalize;">{{ $payment->payment_method }}</span>
                </td>
                <td style="padding: 1rem 1.5rem; color: var(--text-muted);">{{ $payment->reference_number ?? '---' }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

<div style="margin-top: 2rem;">
    {{ $payments->links() }}
</div>
@endsection
