@extends('layouts.components.user')
@section('title', 'Beranda Pengguna')

@section('content')
<div class="row">
    <div class="col-md-10 offset-md-1">
        <div class="alert alert-info d-flex justify-content-between align-items-center">
            <div>
                <strong>{{ $greeting }}</strong>, {{ $user->name }} 👋
            </div>
            <div class="text-muted">
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
                📝 Kirim Laporan Baru
            </a>
        </div>

        @if($latestReport ?? false)
            <div class="alert alert-warning mt-4">
                Laporan terakhir kamu: <strong>{{ $latestReport->created_at->diffForHumans() }}</strong> 
                untuk <em>{{ $latestReport->product->nama_barang }}</em>
            </div>
        @endif
    </div>
</div>
@endsection