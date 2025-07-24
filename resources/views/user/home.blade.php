@extends('layouts.components.user')
@section('title', 'Beranda Pengguna')
@section('content')
<div class="alert alert-info"><strong>{{ $greeting }}</strong>, {{ $user->name }} 👋</div>
<p class="lead">Selamat datang! Kamu bisa melihat daftar alat dan mengirim laporan kondisi terkini.</p>
@endsection