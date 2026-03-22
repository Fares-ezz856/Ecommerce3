<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
@extends('layouts.admin')

@section('page-title', 'Edit Profile: ' . $admin->name)

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
    <form action="{{ route('admin.update.profile') }}" method="POST">
        @csrf


        <div class="form-group" style="margin-bottom: 1.5rem;">
            <label style="display: block; margin-bottom: 0.5rem; font-weight: 600;">{{ __('Admin Name') }} *</label>
            <input type="text" name="name" value="{{ $admin->name }}" class="form-control"  style="width: 100%; padding: 10px; border: 1px solid #e2e8f0; border-radius: 8px;">
        </div>

        <div class="form-group" style="margin-bottom: 2rem;">
            <label style="display: block; margin-bottom: 0.5rem; font-weight: 600;">{{ __('Old Password') }}</label>
             <input type="text" name="old_password" class="form-control"  style="width: 100%; padding: 10px; border: 1px solid #e2e8f0; border-radius: 8px;">
        </div>
        @error('old_password')
        {{ $message }}
        @enderror

          <div class="form-group" style="margin-bottom: 2rem;">
            <label style="display: block; margin-bottom: 0.5rem; font-weight: 600;">{{ __('New Password') }}</label>
             <input type="text" name="new_password" class="form-control"  style="width: 100%; padding: 10px; border: 1px solid #e2e8f0; border-radius: 8px;">
        </div>

        <div style="display: flex; gap: 1rem; justify-content: flex-end;">
            <a href="{{ route('admin.categories.index') }}" style="padding: 10px 20px; border: 1px solid #e2e8f0; border-radius: 8px; text-decoration: none; color: #64748b;">{{ __('Cancel') }}</a>
            <button type="submit" style="padding: 10px 25px; background: var(--primary); color: black; border: 1px solid #64748b; border-radius: 8px; cursor: pointer; font-weight: 600;">{{ __('Update Profile') }}</button>
        </div>
    </form>
</div>
@endsection
