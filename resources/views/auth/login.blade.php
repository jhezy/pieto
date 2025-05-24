@extends('layouts.app')

@section('content')
<div style="display: flex; justify-content: center; align-items: center; min-height: 100vh; background-color: #f3f4f6;">
    <div style="background: white; border-radius: 12px; box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1); width: 100%; max-width: 380px; padding: 30px;">
        <h2 style="text-align: center; margin-bottom: 25px; font-weight: 600;">KEDAI PIETO</h2>
        <!-- <h3 style="text-align: center; margin-bottom: 25px; font-weight: 600;">Masuk</h3> -->

        @if (session('status'))
        <div style="background: #d1e7dd; color: #0f5132; padding: 10px; border-radius: 6px; margin-bottom: 15px;">
            {{ session('status') }}
        </div>
        @endif

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <div style="margin-bottom: 15px;">
                <label for="email" style="display: block; font-weight: 500; margin-bottom: 5px;">Email</label>
                <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus
                    style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 6px; font-size: 14px;">
                @error('email')
                <span style="color: red; font-size: 12px;">{{ $message }}</span>
                @enderror
            </div>

            <div style="margin-bottom: 20px;">
                <label for="password" style="display: block; font-weight: 500; margin-bottom: 5px;">Password</label>
                <input id="password" type="password" name="password" required
                    style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 6px; font-size: 14px;">
                @error('password')
                <span style="color: red; font-size: 12px;">{{ $message }}</span>
                @enderror
            </div>

            <div style="margin-bottom: 15px; display: flex; align-items: center;">
                <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                <label class="form-check-label" for="remember" style="margin-left: 8px; font-size: 14px;">
                    Ingat Saya
                </label>
            </div>

            <div>
                <button type="submit"
                    style="width: 100%; background-color: #2563eb; color: white; padding: 10px; border: none; border-radius: 6px; font-weight: 600;">
                    Masuk
                </button>
            </div>

            <!-- @if (Route::has('password.request'))
            <div style="text-align: right; margin-top: 10px;">
                <a href="{{ route('password.request') }}" style="font-size: 13px; color: #2563eb;">
                    Lupa Password?
                </a>
            </div>
            @endif -->
        </form>

        <!-- <div style="text-align: center; margin-top: 20px; font-size: 14px;">
            Belum punya akun?
            <a href="{{ route('register') }}" style="color: #2563eb; font-weight: 500;">Daftar</a>
        </div> -->
    </div>
</div>
@endsection