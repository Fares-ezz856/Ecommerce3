@extends('layouts.app')

@section('content')
<div class="container py-5 text-center">
    <div class="card shadow-sm p-5 border-warning">
        <div class="mb-4">
            <i class="fas fa-times-circle text-warning" style="font-size: 4rem;"></i>
        </div>
        <h2 class="mb-3">Payment Canceled</h2>
        <p class="text-muted mb-4">The payment process for Invoice #{{ $invoice->invoice_number }} was canceled.</p>
        <div>
            <a href="{{ route('admin.invoices.index') }}" class="btn btn-secondary px-4">Go Back</a>
            <a href="{{ route('stripe.checkout', $invoice->id) }}" class="btn btn-primary px-4">Try Again</a>
        </div>
    </div>
</div>
@endsection
