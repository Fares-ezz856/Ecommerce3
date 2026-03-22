@extends('layouts.shop')

@section('content')
<div style="max-width: 450px; margin: 4rem auto; background: white; padding: 2.5rem; border-radius: 16px; box-shadow: 0 10px 25px rgba(0,0,0,0.05);">
    <h2 style="text-align: center; margin-bottom: 2rem; font-weight: 800; color: #1e293b;">{{ __('Sign In') }}</h2>

    <form action="{{ route('login') }}" method="POST">
        @csrf

        <div style="margin-bottom: 1.5rem;">
            <label style="display: block; margin-bottom: 0.5rem; color: #64748b; font-weight: 500;">{{ __('Email Address') }}</label>
            <input type="email" name="email" value="{{ old('email') }}" required auto-focus
                style="width: 100%; padding: 12px; border: 1px solid #e2e8f0; border-radius: 8px; outline: none; transition: border-color 0.2s;"
                placeholder="you@example.com">
            @error('email')
                <span style="color: #ef4444; font-size: 0.85rem; margin-top: 5px; display: block;">{{ $message }}</span>
            @enderror
        </div>

        <div style="margin-bottom: 1.5rem;">
            <label style="display: block; margin-bottom: 0.5rem; color: #64748b; font-weight: 500;">{{ __('Password') }}</label>
            <input type="password" name="password" required
                style="width: 100%; padding: 12px; border: 1px solid #e2e8f0; border-radius: 8px; outline: none; transition: border-color 0.2s;"
                placeholder="••••••••">
        </div>

        <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 2rem;">
            <label style="display: flex; align-items: center; gap: 0.5rem; color: #64748b; cursor: pointer;">
                <input type="checkbox" name="remember"> {{ __('Remember me') }}
            </label>
            <a href="#" style="color: #3b82f6; font-size: 0.9rem; text-decoration: none;">{{ __('Forgot password') }}?</a>
        </div>

        <button type="submit" style="width: 100%; padding: 12px; background: #3b82f6; color: white; border: none; border-radius: 8px; font-weight: 700; cursor: pointer; transition: background 0.2s;">
            {{ __('Sign In')}}
        </button>
    </form>

    <p style="text-align: center; margin-top: 2rem; color: #64748b;">
        {{ __("Don't have an account?") }} <a href="{{ route('register') }}" style="color: #3b82f6; font-weight: 600; text-decoration: none;">{{ __('Create one') }}</a>
    </p>
</div>
@endsection
