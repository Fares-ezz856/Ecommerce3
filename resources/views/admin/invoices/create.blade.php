@extends('layouts.admin')

@section('page-title', 'Create New Invoice')

@section('content')
<div class="card" style="background: white; padding: 2rem; border-radius: 12px; box-shadow: var(--shadow);">
    <form action="{{ route('admin.invoices.store') }}" method="POST">
        @csrf
        
        <div style="display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 1.5rem; margin-bottom: 2rem;">
            <div class="form-group">
                <label style="display: block; margin-bottom: 0.5rem; font-weight: 600;">Customer *</label>
                <select name="customer_id" class="form-control" required style="width: 100%; padding: 10px; border: 1px solid #e2e8f0; border-radius: 8px;">
                    <option value="">Select Customer</option>
                    @foreach($customers as $customer)
                        <option value="{{ $customer->id }}">{{ $customer->name }} (Balance: ${{ number_format($customer->balance, 2) }})</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label style="display: block; margin-bottom: 0.5rem; font-weight: 600;">Type *</label>
                <select name="type" class="form-control" required style="width: 100%; padding: 10px; border: 1px solid #e2e8f0; border-radius: 8px;">
                    <option value="sale">Sale (Deducts Stock)</option>
                    <option value="purchase">Purchase (Adds Stock)</option>
                    <option value="return">Return</option>
                </select>
            </div>
            <div class="form-group">
                <label style="display: block; margin-bottom: 0.5rem; font-weight: 600;">Payment Method *</label>
                <select name="payment_method" class="form-control" required style="width: 100%; padding: 10px; border: 1px solid #e2e8f0; border-radius: 8px;">
                    <option value="cash">Cash</option>
                    <option value="bank_transfer">Bank Transfer</option>
                    <option value="credit">On Credit (Adds to Balance)</option>
                </select>
            </div>
        </div>

        <h3 style="margin-bottom: 1rem; border-bottom: 2px solid #f1f5f9; padding-bottom: 0.5rem;">Invoice Items</h3>
        
        <div id="items-container">
            <div class="item-row" style="display: grid; grid-template-columns: 3fr 1fr 1fr 0.5fr; gap: 1rem; margin-bottom: 1rem; align-items: flex-end;">
                <div class="form-group">
                    <label style="font-size: 0.8rem; color: #64748b;">Product</label>
                    <select name="items[0][product_id]" class="form-control item-select" required style="width: 100%; padding: 8px; border: 1px solid #e2e8f0; border-radius: 8px;">
                        <option value="">Select Product</option>
                        @foreach($products as $product)
                            <option value="{{ $product->id }}" data-price="{{ $product->price }}">
                                {{ $product->name }} (${{ number_format($product->price, 2) }}) - Stock: {{ $product->stock_quantity }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label style="font-size: 0.8rem; color: #64748b;">Quantity</label>
                    <input type="number" name="items[0][quantity]" class="form-control qty-input" min="1" value="1" required style="width: 100%; padding: 8px; border: 1px solid #e2e8f0; border-radius: 8px;">
                </div>
                <div class="form-group">
                    <label style="font-size: 0.8rem; color: #64748b;">Subtotal</label>
                    <input type="text" class="form-control subtotal-preview" readonly value="0.00" style="width: 100%; padding: 8px; border: 1px solid #f1f5f9; border-radius: 8px; background: #f8fafc;">
                </div>
                <div></div>
            </div>
        </div>

        <button type="button" id="add-item" style="background: #f1f5f9; border: 1px dashed #cbd5e1; padding: 10px; width: 100%; border-radius: 8px; cursor: pointer; color: #475569; margin-bottom: 2rem;">
            <i class="fas fa-plus-circle"></i> Add Another Item
        </button>

        <div style="display: flex; justify-content: flex-end; gap: 2rem; margin-bottom: 2rem; border-top: 2px solid #f1f5f9; padding-top: 1.5rem;">
            <div class="form-group">
                <label style="display: block; margin-bottom: 0.5rem; font-weight: 600;">Overall Discount ($)</label>
                <input type="number" step="0.01" name="discount" id="discount-input" value="0" style="width: 150px; padding: 10px; border: 1px solid #e2e8f0; border-radius: 8px;">
            </div>
            <div style="text-align: right;">
                <h4 style="color: #64748b; margin: 0;">Total Amount</h4>
                <div style="font-size: 2rem; font-weight: 800; color: var(--primary);">$<span id="grand-total">0.00</span></div>
            </div>
        </div>

        <div style="display: flex; gap: 1rem; justify-content: flex-end;">
            <a href="{{ route('admin.invoices.index') }}" style="padding: 10px 20px; border: 1px solid #e2e8f0; border-radius: 8px; text-decoration: none; color: #64748b;">Cancel</a>
            <button type="submit" style="padding: 10px 25px; background: var(--primary); color: white; border: none; border-radius: 8px; cursor: pointer; font-weight: 600;">Create Draft Invoice</button>
        </div>
    </form>
</div>

@section('scripts')
<script>
    let itemIndex = 1;
    const container = document.getElementById('items-container');
    const addButton = document.getElementById('add-item');
    const grandTotalSpan = document.getElementById('grand-total');
    const discountInput = document.getElementById('discount-input');

    addButton.addEventListener('click', () => {
        const row = document.createElement('div');
        row.className = 'item-row';
        row.style = 'display: grid; grid-template-columns: 3fr 1fr 1fr 0.5fr; gap: 1rem; margin-bottom: 1rem; align-items: flex-end;';
        row.innerHTML = `
            <div class="form-group">
                <select name="items[${itemIndex}][product_id]" class="form-control item-select" required style="width: 100%; padding: 8px; border: 1px solid #e2e8f0; border-radius: 8px;">
                    <option value="">Select Product</option>
                    @foreach($products as $product)
                        <option value="{{ $product->id }}" data-price="{{ $product->price }}">
                            {{ $product->name }} (${{ number_format($product->price, 2) }})
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <input type="number" name="items[${itemIndex}][quantity]" class="form-control qty-input" min="1" value="1" required style="width: 100%; padding: 8px; border: 1px solid #e2e8f0; border-radius: 8px;">
            </div>
            <div class="form-group">
                <input type="text" class="form-control subtotal-preview" readonly value="0.00" style="width: 100%; padding: 8px; border: 1px solid #f1f5f9; border-radius: 8px; background: #f8fafc;">
            </div>
            <button type="button" class="remove-item" style="background: none; border: none; color: #ef4444; cursor: pointer; padding-bottom: 10px;"><i class="fas fa-times"></i></button>
        `;
        container.appendChild(row);
        itemIndex++;
        attachListeners(row);
    });

    function attachListeners(row) {
        const select = row.querySelector('.item-select');
        const qty = row.querySelector('.qty-input');
        const subtotal = row.querySelector('.subtotal-preview');
        const remove = row.querySelector('.remove-item');

        const calculate = () => {
            const price = select.options[select.selectedIndex]?.dataset.price || 0;
            subtotal.value = (price * qty.value).toFixed(2);
            updateGrandTotal();
        };

        select.addEventListener('change', calculate);
        qty.addEventListener('input', calculate);
        if(remove) remove.addEventListener('click', () => { row.remove(); updateGrandTotal(); });
    }

    function updateGrandTotal() {
        let total = 0;
        document.querySelectorAll('.subtotal-preview').forEach(input => {
            total += parseFloat(input.value || 0);
        });
        const discount = parseFloat(discountInput.value || 0);
        grandTotalSpan.innerText = (total - discount).toFixed(2);
    }

    attachListeners(container.querySelector('.item-row'));
    discountInput.addEventListener('input', updateGrandTotal);
</script>
@endsection
@endsection
