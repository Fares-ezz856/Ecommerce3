<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
@extends('layouts.admin')

@section('page-title', 'Add Admin')

@section('content')
@if (session()->has('success'))
 <div class="alert alert-success">
    {{ session('success') }}
 </div>
@endif
@if (session()->has('error'))
 <div class="alert alert-danger">
    {{ session('error') }}
 </div>
@endif
<div class="card" style="background: white; padding: 2rem; border-radius: 12px; box-shadow: var(--shadow); max-width: 600px; margin: 0 auto;">
    <form action="{{ route('admin.admins.store') }}" method="POST">
        @csrf

        <div class="form-group" style="margin-bottom: 1.5rem;">
            <label style="display: block; margin-bottom: 0.5rem; font-weight: 600;">Admin Name *</label>
            <input type="text" name="name" class="form-control" required placeholder="Name" style="width: 100%; padding: 10px; border: 1px solid #e2e8f0; border-radius: 8px;">
        </div>

        <div class="form-group" style="margin-bottom: 2rem;">
            <label style="display: block; margin-bottom: 0.5rem; font-weight: 600;">Email</label>
             <input type="email" name="email" class="form-control" required placeholder="Email" style="width: 100%; padding: 10px; border: 1px solid #e2e8f0; border-radius: 8px;">
        </div>

          {{-- <div class="form-group" style="margin-bottom: 2rem;">
            <label style="display: block; margin-bottom: 0.5rem; font-weight: 600;">Password</label>
             <input type="password" name="password" class="form-control" required placeholder="Password" style="width: 100%; padding: 10px; border: 1px solid #e2e8f0; border-radius: 8px;">
        </div> --}}

        <div style="display: flex; gap: 1rem; justify-content: flex-end;">
            {{-- <a href="{{ route('admin.admins.index') }}" style="padding: 10px 20px; border: 1px solid #e2e8f0; border-radius: 8px; text-decoration: none; color: #64748b;">Cancel</a> --}}
            <button type="submit" style="padding: 10px 25px; background: var(--primary); color: black; border: 1px solid #64748b; border-radius: 8px; cursor: pointer; font-weight: 600;">Create </button>
        </div>
    </form>
</div>
@endsection
