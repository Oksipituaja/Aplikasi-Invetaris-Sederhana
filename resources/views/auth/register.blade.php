@extends('layouts.auth')

@section('content')
<div class="text-center mb-4">
    <h4><i class="fas fa-user-plus me-2"></i>Daftar Akun Baru</h4>
</div>

@if ($errors->any())
    <div class="alert alert-danger small">
        {{ $errors->first() }}
    </div>
@endif

<form method="POST" action="{{ route('register') }}">
    @csrf

    <div class="mb-3">
        <label class="form-label">Nama</label>
        <input type="text" name="name" autocomplete="name" class="form-control form-control-lg" placeholder="Nama lengkap" value="{{ old('name') }}" required>
        @error('name') <small class="text-danger">{{ $message }}</small> @enderror
    </div>

    <div class="mb-3">
        <label class="form-label">Email</label>
        <input type="email" name="email" class="form-control form-control-lg" placeholder="example@gmail.com" value="{{ old('email') }}" required>
        @error('email') <small class="text-danger">{{ $message }}</small> @enderror
    </div>

    <div class="mb-3">
        <label class="form-label">Password</label>
        <input type="password" name="password" class="form-control form-control-lg" placeholder="••••••" required>
        @error('password') <small class="text-danger">{{ $message }}</small> @enderror
    </div>

    <div class="mb-4">
        <label class="form-label">Konfirmasi Password</label>
        <input type="password" name="password_confirmation" class="form-control form-control-lg" placeholder="••••••" required>
    </div>

    <button type="submit" class="btn btn-success w-100 btn-lg">
        <i class="fas fa-user-check me-2"></i>Daftar
    </button>
</form>

<div class="mt-3 text-center">
    <a href="{{ route('login') }}">
        Sudah punya akun? Login sekarang <i class="fas fa-sign-in-alt ms-1"></i>
    </a>
</div>
@endsection