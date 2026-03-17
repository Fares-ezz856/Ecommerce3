@extends('layouts.admin')

@section('page-title', 'Edit Customer: ' . $customer->name)

@section('content')
<div class="card" style="background: white; padding: 2rem; border-radius: 12px; box-shadow: var(--shadow); max-width: 600px; margin: 0 auto;">
    <form action="{{ route('admin.customers.update', $customer->id) }}" method="POST">
        @csrf
        @method('PUT')
        
        <div class="form-group" style="margin-bottom: 1.5rem;">
            <label style="display: block; margin-bottom: 0.5rem; font-weight: 600;">Customer Name *</label>
            <input type="text" name="name" value="{{ $customer->name }}" class="form-control" required style="width: 100%; padding: 10px; border: 1px solid #e2e8f0; border-radius: 8px;">
        </div>

        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem; margin-bottom: 1.5rem;">
            <div class="form-group">
                <label style="display: block; margin-bottom: 0.5rem; font-weight: 600;">Phone Number</label>
                <input type="text" name="phone" value="{{ $customer->phone }}" style="width: 100%; padding: 10px; border: 1px solid #e2e8f0; border-radius: 8px;">
            </div>
            <div class="form-group">
                <label style="display: block; margin-bottom: 0.5rem; font-weight: 600;">Email Address</label>
                <input type="email" name="email" value="{{ $customer->email }}" style="width: 100%; padding: 10px; border: 1px solid #e2e8f0; border-radius: 8px;">
            </div>
        </div>

        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem; margin-bottom: 1.5rem;">
            <div class="form-group">
                <label style="display: block; margin-bottom: 0.5rem; font-weight: 600;">Customer Type *</label>
                <select name="type" class="form-control" required style="width: 100%; padding: 10px; border: 1px solid #e2e8f0; border-radius: 8px;">
                    <option value="individual" {{ $customer->type == 'individual' ? 'selected' : '' }}>Individual</option>
                    <option value="trader" {{ $customer->type == 'trader' ? 'selected' : '' }}>Trader / Merchant</option>
                </select>
            </div>
            <div class="form-group">
                <label style="display: block; margin-bottom: 0.5rem; font-weight: 600;">Current Balance (Debt)</label>
                <input type="number" step="0.01" name="balance" value="{{ $customer->balance }}" style="width: 100%; padding: 10px; border: 1px solid #e2e8f0; border-radius: 8px;">
            </div>
        </div>

        <div class="form-group" style="margin-bottom: 2rem;">
            <label style="display: block; margin-bottom: 0.5rem; font-weight: 600;">Address / Store Location</label>
            <textarea name="address" rows="3" style="width: 100%; padding: 10px; border: 1px solid #e2e8f0; border-radius: 8px;">{{ $customer->address }}</textarea>
        </div>

        <div style="display: flex; gap: 1rem; justify-content: flex-end;">
            <a href="{{ route('admin.customers.index') }}" style="padding: 10px 20px; border: 1px solid #e2e8f0; border-radius: 8px; text-decoration: none; color: #64748b;">Cancel</a>
            <button type="submit" style="padding: 10px 25px; background: var(--primary); color: white; border: none; border-radius: 8px; cursor: pointer; font-weight: 600;">Update Profile</button>
        </div>
    </form>
</div>
@endsection
