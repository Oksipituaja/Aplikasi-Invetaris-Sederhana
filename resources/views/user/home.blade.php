{{-- FIX: Ubah extends ke layouts.user --}}
@extends('layouts.user')

@section('title', 'Beranda Pengguna')

@section('content')
<div class="row">
    <div class="col-md-10 offset-md-1">
        <div class="alert alert-info d-flex justify-content-between align-items-center shadow-sm">
            <div>
                {{-- Menggunakan null coalescing operator (??) untuk keamanan --}}
                <strong>{{ $greeting ?? 'Halo' }}</strong>, {{ $user->name }} 👋
            </div>
            <div class="text-white-75">
                {{ now()->translatedFormat('l, d F Y - H:i') }}
            </div>
        </div>

        <p class="lead mt-3">
            Selamat datang di dashboard pengguna! Kamu bisa melihat daftar barang inventaris dan mengirim laporan kondisi.
        </p>

        <div class="btn-group mt-4">
            <a href="{{ route('user.products.index') }}" class="btn btn-outline-primary">
                📦 Daftar Barang
            </a>
            <a href="{{ route('user.products.create') }}" class="btn btn-outline-success">
                📝 Input Barang Baru
            </a>
        </div>
    </div>
</div>
@endsection