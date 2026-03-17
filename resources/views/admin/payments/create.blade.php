@extends('layouts.admin')

@section('page-title', 'Record New Payment')

@section('content')
<div class="card" style="background: white; padding: 2rem; border-radius: 12px; box-shadow: var(--shadow); max-width: 600px; margin: 0 auto;">
    <form action="{{ route('admin.payments.store') }}" method="POST">
        @csrf
        
        <div class="form-group" style="margin-bottom: 1.5rem;">
            <label style="display: block; margin-bottom: 0.5rem; font-weight: 600;">Customer *</label>
            <select name="customer_id" id="customer_id" class="form-control" required style="width: 100%; padding: 10px; border: 1px solid #e2e8f0; border-radius: 8px;">
                <option value="">Select Customer</option>
                @foreach($customers as $customer)
                    <option value="{{ $customer->id }}" {{ request('customer_id') == $customer->id ? 'selected' : '' }}>
                        {{ $customer->name }} (Balance: ${{ number_format($customer->balance, 2) }})
                    </option>
                @endforeach
            </select>
        </div>

        <div class="form-group" style="margin-bottom: 1.5rem;">
            <label style="display: block; margin-bottom: 0.5rem; font-weight: 600;">Apply to Invoice (Optional)</label>
            <select name="invoice_id" id="invoice_id" class="form-control" style="width: 100%; padding: 10px; border: 1px solid #e2e8f0; border-radius: 8px;">
                <option value="">General Payment / No Invoice</option>
                @foreach($invoices as $invoice)
                    <option value="{{ $invoice->id }}">{{ $invoice->invoice_number }} (Remaining: ${{ number_format($invoice->total_amount, 2) }})</option>
                @endforeach
            </select>
            <p style="font-size: 0.75rem; color: #64748b; margin-top: 5px;">Note: You can only select confirmed invoices for the chosen customer.</p>
        </div>

        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem; margin-bottom: 1.5rem;">
            <div class="form-group">
                <label style="display: block; margin-bottom: 0.5rem; font-weight: 600;">Amount Paid *</label>
                <input type="number" step="0.01" name="amount" class="form-control" required style="width: 100%; padding: 10px; border: 1px solid #e2e8f0; border-radius: 8px;">
            </div>
            <div class="form-group">
                <label style="display: block; margin-bottom: 0.5rem; font-weight: 600;">Payment Method *</label>
                <select name="payment_method" class="form-control" required style="width: 100%; padding: 10px; border: 1px solid #e2e8f0; border-radius: 8px;">
                    <option value="cash">Cash</option>
                    <option value="bank_transfer">Bank Transfer</option>
                    <option value="check">Check</option>
                </select>
            </div>
        </div>

        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem; margin-bottom: 1.5rem;">
            <div class="form-group">
                <label style="display: block; margin-bottom: 0.5rem; font-weight: 600;">Date *</label>
                <input type="date" name="payment_date" value="{{ date('Y-m-d') }}" class="form-control" required style="width: 100%; padding: 10px; border: 1px solid #e2e8f0; border-radius: 8px;">
            </div>
            <div class="form-group">
                <label style="display: block; margin-bottom: 0.5rem; font-weight: 600;">Reference #</label>
                <input type="text" name="reference_number" class="form-control" placeholder="E.g. TXN-12345" style="width: 100%; padding: 10px; border: 1px solid #e2e8f0; border-radius: 8px;">
            </div>
        </div>

        <div class="form-group" style="margin-bottom: 2rem;">
            <label style="display: block; margin-bottom: 0.5rem; font-weight: 600;">Notes</label>
            <textarea name="notes" rows="2" style="width: 100%; padding: 10px; border: 1px solid #e2e8f0; border-radius: 8px;"></textarea>
        </div>

        <div style="display: flex; gap: 1rem; justify-content: flex-end;">
            <a href="{{ route('admin.payments.index') }}" style="padding: 10px 20px; border: 1px solid #e2e8f0; border-radius: 8px; text-decoration: none; color: #64748b;">Cancel</a>
            <button type="submit" style="padding: 10px 25px; background: var(--primary); color: white; border: none; border-radius: 8px; cursor: pointer; font-weight: 600;">Record Payment</button>
        </div>
    </form>
</div>

@section('scripts')
<script>
    document.getElementById('customer_id').addEventListener('change', function() {
        const customerId = this.value;
        if(customerId) {
            window.location.href = `{{ route('admin.payments.create') }}?customer_id=${customerId}`;
        }
    });
</script>
@endsection
@endsection
