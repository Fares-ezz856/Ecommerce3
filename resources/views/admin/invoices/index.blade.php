@extends('layouts.admin')

@section('page-title', __('Invoices & Billing'))

@section('content')
<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;">
    <h2 style="font-weight: 700;">{{ __('Invoice Management') }}</h2>
    <a href="{{ route('admin.invoices.create') }}" style="background: var(--primary); color: white; padding: 10px 20px; border-radius: 8px; text-decoration: none;">
        <i class="fas fa-plus"></i> {{ __('New Invoice') }}
    </a>
</div>

<div class="table-card" style="background: white; border-radius: 12px; box-shadow: var(--shadow); overflow: hidden;">
    <table style="width: 100%; border-collapse: collapse;">
        <thead>
            <tr style="background: #f8fafc; text-align: left;">
                <th style="padding: 1rem 1.5rem; color: var(--text-muted); font-size: 0.8rem; text-transform: uppercase;">{{ __('Invoice #') }}</th>
                <th style="padding: 1rem 1.5rem; color: var(--text-muted); font-size: 0.8rem; text-transform: uppercase;">{{ __('Customer') }}</th>
                <th style="padding: 1rem 1.5rem; color: var(--text-muted); font-size: 0.8rem; text-transform: uppercase;">{{ __('Type') }}</th>
                <th style="padding: 1rem 1.5rem; color: var(--text-muted); font-size: 0.8rem; text-transform: uppercase;">{{ __('Total') }}</th>
                <th style="padding: 1rem 1.5rem; color: var(--text-muted); font-size: 0.8rem; text-transform: uppercase;">{{ __('Status') }}</th>
                <th style="padding: 1rem 1.5rem; color: var(--text-muted); font-size: 0.8rem; text-transform: uppercase;">{{ __('Date') }}</th>
                <th style="padding: 1rem 1.5rem; color: var(--text-muted); font-size: 0.8rem; text-transform: uppercase;">{{ __('Actions') }}</th>
            </tr>
        </thead>
        <tbody>
            @foreach($invoices as $invoice)
            <tr style="border-bottom: 1px solid #edf2f7;">
                <td style="padding: 1rem 1.5rem; font-family: monospace; font-weight: 600;">{{ $invoice->invoice_number }}</td>
                <td style="padding: 1rem 1.5rem;">{{ $invoice->customer->name }}</td>
                <td style="padding: 1rem 1.5rem;">
                    <span style="text-transform: capitalize;">{{ __($invoice->type) }}</span>
                </td>
                <td style="padding: 1rem 1.5rem; font-weight: 700;">${{ number_format($invoice->total_amount, 2) }}</td>
                <td style="padding: 1rem 1.5rem;">
                    <span class="badge" style="padding: 4px 10px; border-radius: 20px; font-size: 0.75rem; font-weight: 600;
                        @if($invoice->status == 'confirmed') background: #d1fae5; color: #065f46;
                        @elseif($invoice->status == 'pending') background: #fef3c7; color: #92400e;
                        @else background: #fee2e2; color: #991b1b; @endif">
                        {{ strtoupper(__($invoice->status)) }}
                    </span>
                </td>
                <td style="padding: 1rem 1.5rem; color: var(--text-muted);">{{ $invoice->created_at->format('Y-m-d') }}</td>
                <td style="padding: 1rem 1.5rem;">
                    <a href="{{ route('admin.invoices.show', $invoice->id) }}" style="color: #0369a1; margin-right: 15px;"><i class="fas fa-eye"></i> {{ __('View') }}</a>
                    @if($invoice->status != 'paid')
                        <a href="{{ route('stripe.checkout', $invoice->id) }}" style="color: #6366f1; font-weight: 600;">
                            <i class="fab fa-stripe"></i> {{ __('Pay') }}
                        </a>
                    @endif
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

<div style="margin-top: 2rem;">
    {{ $invoices->links() }}
</div>
@endsection
