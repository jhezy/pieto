@extends('layouts.app')

@section('content')
<div style="display: flex; justify-content: center; align-items: center; min-height: 100vh; background-color:rgb(255, 246, 217);">
    <div style="background: white; border-radius: 16px; box-shadow: 0 8px 30px rgba(236, 184, 74, 0.85); width: 100%; max-width: 400px; padding: 35px;">
        <h2 style="text-align: center; margin-bottom: 25px; font-weight: bold; color:rgb(238, 202, 22);">KEDAI PIETO</h2>

        @if (session('status'))
        <div class="alert alert-success">
            {{ session('status') }}
        </div>
        @endif

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <div class="mb-3">
                <label for="email" class="form-label fw-semibold">Email</label>
                <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus
                    class="form-control @error('email') is-invalid @enderror">
                @error('email')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="password" class="form-label fw-semibold">Password</label>
                <input id="password" type="password" name="password" required
                    class="form-control @error('password') is-invalid @enderror">
                @error('password')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
                @enderror
            </div>

            <div class="form-check mb-3">
                <input class="form-check-input" type="checkbox" name="remember" id="remember"
                    {{ old('remember') ? 'checked' : '' }}>
                <label class="form-check-label" for="remember">
                    Ingat Saya
                </label>
            </div>

            <div class="d-grid">
                <button type="submit" class="btn btn-warning fw-bold">
                    Masuk
                </button>
            </div>
        </form>

        <!-- <div class="text-center mt-4">
            <small>Belum punya akun? <a href="{{ route('register') }}" class="text-warning fw-semibold">Daftar</a></small>
        </div> -->
    </div>
</div>
@endsection