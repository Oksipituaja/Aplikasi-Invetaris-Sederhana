@extends('layouts.main')

@section('header')
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1>Daftar Produk</h1>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Beranda</a></li>
                <li class="breadcrumb-item active">Produk</li>
            </ol>
        </div>
    </div>
@endsection

@section('content')
<div class="row">
    <div class="col">
        <div class="card">
            <div class="card-body">

                <a href="{{ route('admin.products.create') }}" class="btn btn-success mb-3">
                    <i class="fas fa-plus"></i> Tambah Produk
                </a>

                <form method="GET" action="{{ route('admin.products.index') }}" class="mb-3">
                    <div class="row">
                        <div class="col-md-4">
                            <select name="category_id" class="form-control" onchange="this.form.submit()">
                                <option value="">-- Semua Kategori --</option>
                                @foreach ($categories as $cat)
                                    <option value="{{ $cat->id }}" {{ request('category_id') == $cat->id ? 'selected' : '' }}>
                                        {{ $cat->nama_barang }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </form>

                @if (session('success'))
                    <div class="alert alert-success alert-dismissible fade show" id="success-alert">
                        {{ session('success') }}
                        <button type="button" class="close" data-dismiss="alert">&times;</button>
                    </div>
                    <script>
                        setTimeout(function() {
                            let alertBox = document.getElementById('success-alert');
                            if (alertBox) {
                                alertBox.classList.remove('show');
                                alertBox.classList.add('fade');
                                alertBox.style.opacity = '0';
                                setTimeout(() => alertBox.remove(), 500);
                            }
                        }, 5000);
                    </script>
                @endif

                <div class="table-responsive">
                    <table class="table table-bordered table-striped">
                        <thead class="thead-light">
                            <tr>
                                <th>No</th>
                                <th>Nama Lengkap</th>
                                <th>NIM</th>
                                <th>Prodi</th>
                                <th>Nama Barang</th>
                                <th>Keterangan</th>
                                <th>NUP/Ruangan</th>
                                <th>Tanggal Mulai</th>
                                <th>Tanggal Selesai</th>
                                <th>Stok</th>
                                <th>Kategori</th>
                                <th style="width: 120px;">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($products as $product)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $product->nama_lengkap }}</td>
                                    <td>{{ $product->nim }}</td>
                                    <td>{{ $product->prodi }}</td>
                                    <td>{{ $product->nama_barang }}</td>
                                    <td>{{ $product->description ?? '-' }}</td>
                                    <td>{{ $product->nup_ruangan ?? '-' }}</td>
                                    <td>{{ optional($product->tanggal_mulai)->timezone('Asia/Jakarta')->format('d M Y H:i') }}</td>
                                    <td>{{ optional($product->tanggal_selesai)->timezone('Asia/Jakarta')->format('d M Y H:i') ?? '-' }}</td>
                                    <td>{{ $product->stok_barang ?? '-' }}</td>
                                    <td>{{ $product->category->nama_barang ?? '-' }}</td>
                                    <td>
                                        <div class="btn-group btn-group-sm" role="group">
                                            <a href="{{ route('admin.products.edit', $product->id) }}" 
                                               class="btn btn-warning" title="Edit">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <form action="{{ route('admin.products.destroy', $product->id) }}" 
                                                  method="POST" style="display:inline;">
                                                @csrf
                                                @method('DELETE')
