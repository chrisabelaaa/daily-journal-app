@extends('layouts.app')

@section('content')
<div class="login-container" style="margin: 0 auto; max-width: 370px; padding: 2.5rem 2rem; background: #F2C4CD; border-radius: 1.25rem; box-shadow: 0 8px 32px rgba(5, 31, 69, 0.10);">
    <div class="login-title" style="font-size: 2rem; font-weight: 600; color: #051F45; text-align: center; margin-bottom: 0.5rem;">Reset Password</div>
    @if (session('status'))
        <div style="color: #166534; background: #dcfce7; border-radius: 0.5rem; padding: 0.75rem 1rem; margin-bottom: 0.5rem; font-size: 0.98rem;">
            {{ session('status') }}
        </div>
    @endif
    <form class="login-form" method="POST" action="{{ route('password.email') }}">
        @csrf
        <div>
            <label for="email" style="color:#051F45;">Email</label>
            <input type="email" id="email" name="email" value="{{ old('email') }}" required autofocus placeholder="you@email.com" style="padding: 0.75rem 1rem; border: 1px solid #051F45; border-radius: 0.5rem; font-size: 1rem; background: #fff; color: #051F45; width:100%;">
        </div>
        @if ($errors->has('email'))
            <div style="color: #b91c1c; background: #fee2e2; border-radius: 0.5rem; padding: 0.75rem 1rem; margin-top: 0.5rem; font-size: 0.98rem;">
                {{ $errors->first('email') }}
            </div>
        @endif
        <button type="submit" style="margin-top:1rem; padding: 0.75rem 1rem; background: #051F45; color: #F2C4CD; font-size: 1.1rem; font-weight: 600; border: none; border-radius: 0.5rem; cursor: pointer; width:100%;">Send Password Reset Link</button>
    </form>
    <div class="login-footer" style="text-align:center; font-size:0.95rem; color:#051F45; margin-top:1.5rem;">
        <a href="{{ route('login') }}" style="color:#051F45; text-decoration:underline;">Back to Login</a>
    </div>
</div>
@endsection
