@extends('layouts.admin')

@section('page-title', 'Manage Customers')

@section('content')
<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;">
    <h2 style="font-weight: 700;">Customer Database</h2>
    <a href="{{ route('admin.customers.create') }}" style="background: var(--primary); color: white; padding: 10px 20px; border-radius: 8px; text-decoration: none;">
        <i class="fas fa-user-plus"></i> Add Customer
    </a>
</div>

<div class="table-card" style="background: white; border-radius: 12px; box-shadow: var(--shadow); overflow: hidden;">
    <table style="width: 100%; border-collapse: collapse;">
        <thead>
            <tr style="background: #f8fafc; text-align: left;">
                <th style="padding: 1rem 1.5rem; color: var(--text-muted); font-size: 0.8rem; text-transform: uppercase;">Customer</th>
                <th style="padding: 1rem 1.5rem; color: var(--text-muted); font-size: 0.8rem; text-transform: uppercase;">Contact</th>
                <th style="padding: 1rem 1.5rem; color: var(--text-muted); font-size: 0.8rem; text-transform: uppercase;">Type</th>
                <th style="padding: 1rem 1.5rem; color: var(--text-muted); font-size: 0.8rem; text-transform: uppercase;">Outstanding Balance</th>
                <th style="padding: 1rem 1.5rem; color: var(--text-muted); font-size: 0.8rem; text-transform: uppercase;">Invoices</th>
                <th style="padding: 1rem 1.5rem; color: var(--text-muted); font-size: 0.8rem; text-transform: uppercase;">Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($customers as $customer)
            <tr style="border-bottom: 1px solid #edf2f7;">
                <td style="padding: 1rem 1.5rem;">
                    <strong style="display: block;">{{ $customer->name }}</strong>
                    <small style="color: var(--text-muted);">{{ $customer->address }}</small>
                </td>
                <td style="padding: 1rem 1.5rem;">
                    {{ $customer->phone }}<br>
                    <small style="color: #0369a1;">{{ $customer->email }}</small>
                </td>
                <td style="padding: 1rem 1.5rem;">
                    <span class="badge" style="background: #f1f5f9; color: #475569; padding: 4px 10px; border-radius: 20px; font-size: 0.75rem; text-transform: uppercase; font-weight: 600;">
                        {{ $customer->type }}
                    </span>
                </td>
                <td style="padding: 1rem 1.5rem; font-weight: 700; color: {{ $customer->balance > 0 ? '#991b1b' : '#065f46' }};">
                    ${{ number_format($customer->balance, 2) }}
                </td>
                <td style="padding: 1rem 1.5rem; text-align: center;">
                    <span style="font-weight: 600;">{{ $customer->invoices_count }}</span>
                </td>
                <td style="padding: 1rem 1.5rem; display: flex; gap: 0.5rem;">
                    <a href="{{ route('admin.customers.edit', $customer->id) }}" style="color: #0369a1;"><i class="fas fa-edit"></i></a>
                    <form action="{{ route('admin.customers.destroy', $customer->id) }}" method="POST" onsubmit="return confirm('Delete this customer profile?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" style="background: none; border: none; color: #991b1b; cursor: pointer; padding: 0;"><i class="fas fa-trash"></i></button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

<div style="margin-top: 2rem;">
    {{ $customers->links() }}
</div>
@endsection
