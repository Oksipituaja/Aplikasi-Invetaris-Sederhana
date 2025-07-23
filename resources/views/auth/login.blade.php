@extends('layouts.auth')

@section('content')
<div class="text-center mb-4">
    <h4><i class="fas fa-sign-in-alt me-2"></i>Login ke Sistem</h4>
</div>

@if ($errors->any())
    <div class="alert alert-danger">
        {{ $errors->first() }}
    </div>
@endif

<form method="POST" action="{{ route('login') }}">
    @csrf

    <div class="mb-3">
        <label class="form-label">Email</label>
        <input type="email" name="email" autocomplete="name" class="form-control form-control-lg" placeholder="email@domain.com" value="{{ old('email') }}" required>
        @error('email') <small class="text-danger">{{ $message }}</small> @enderror
    </div>

    <div class="mb-4">
        <label class="form-label">Password</label>
        <input type="password" name="password" class="form-control form-control-lg" placeholder="••••••" required>
        @error('password') <small class="text-danger">{{ $message }}</small> @enderror
    </div>

    <button type="submit" class="btn btn-primary w-100 btn-lg">
        <i class="fas fa-arrow-right-to-bracket me-2"></i>Masuk
    </button>
</form>

<div class="mt-3 text-center">
    <a href="{{ route('register') }}">
        Belum punya akun? Daftar sekarang <i class="fas fa-user-plus ms-1"></i>
    </a>
</div>
@endsection