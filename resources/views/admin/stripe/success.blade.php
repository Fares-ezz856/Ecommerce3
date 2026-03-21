@extends('layouts.app')

@section('content')
<div class="container py-5 text-center">
    <div class="card shadow-sm p-5">
        <div class="mb-4">
            <i class="fas fa-check-circle text-success" style="font-size: 4rem;"></i>
        </div>
        <h2 class="mb-3">Payment Successful!</h2>
        <p class="text-muted mb-4">Thank you for your payment for Invoice #{{ $invoice->invoice_number }}.</p>
        <div class="mb-4">
            <span class="badge bg-success p-2">Amount Paid: ${{ number_format($invoice->total_amount, 2) }}</span>
        </div>
        <div>
            <a href="{{ route('admin.invoices.index') }}" class="btn btn-primary px-4">View My Invoices</a>
        </div>
    </div>
</div>
@endsection
