@extends('layouts.main')

@section('header')
    <h1>Edit Produk: {{ $product->nama_barang }}</h1>
@endsection

@section('content')
<div class="row">
    <div class="col-md-8 offset-md-2">
        <div class="card shadow-sm">
            <div class="card-body">
                <form action="{{ route('user.products.update', $product->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="form-group">
                        <label>Nama Lengkap</label>
                        <input type="text" name="nama_lengkap" class="form-control"
                            value="{{ old('nama_lengkap', $product->nama_lengkap) }}">
                        @error('nama_lengkap')<div class="text-danger">{{ $message }}</div>@enderror
                    </div>

                    <div class="form-group">
                        <label>NIM</label>
                        <input type="text" name="nim" class="form-control"
                            value="{{ old('nim', $product->nim) }}">
                        @error('nim')<div class="text-danger">{{ $message }}</div>@enderror
                    </div>

                    <div class="form-group">
                        <label>Prodi</label>
                        <select name="prodi" class="form-control">
                            <option value="">-- Pilih Prodi --</option>
                            @php
                                $prodis = ['Teknik Informatika','Sistem Informasi','Manajemen','Akuntansi','Pendidikan'];
                            @endphp
                            @foreach ($prodis as $p)
                                <option value="{{ $p }}" {{ old('prodi', $product->prodi) == $p ? 'selected' : '' }}>
                                    {{ $p }}
                                </option>
                            @endforeach
                        </select>
                        @error('prodi')<div class="text-danger">{{ $message }}</div>@enderror
                    </div>

                    <div class="form-group">
                        <label>Nama Barang</label>
                        <input type="text" name="nama_barang" class="form-control"
                            value="{{ old('nama_barang', $product->nama_barang) }}">
                        @error('nama_barang')<div class="text-danger">{{ $message }}</div>@enderror
                    </div>

                    <div class="form-group">
                        <label>Keterangan</label>
                        <textarea name="description" class="form-control">{{ old('description', $product->description) }}</textarea>
                    </div>

                    <div class="form-group">
                        <label>NUP/Ruangan</label>
                        <input type="text" name="nup_ruangan" class="form-control"
                            value="{{ old('nup_ruangan', $product->nup_ruangan) }}">
                        @error('nup_ruangan')<div class="text-danger">{{ $message }}</div>@enderror
                    </div>

                    <div class="form-group">
                        <label>Tanggal Mulai</label>
                        <input type="date" name="tanggal_mulai" class="form-control"
                            value="{{ old('tanggal_mulai', $product->tanggal_mulai ? $product->tanggal_mulai->format('Y-m-d') : '') }}">
                        @error('tanggal_mulai')<div class="text-danger">{{ $message }}</div>@enderror
                    </div>
                    
                    <div class="form-group">
                        <label>Tanggal Selesai</label>
                        <input type="date" name="tanggal_selesai" class="form-control"
                            value="{{ old('tanggal_selesai', $product->tanggal_selesai ? $product->tanggal_selesai->format('Y-m-d') : '') }}">
                        @error('tanggal_selesai')<div class="text-danger">{{ $message }}</div>@enderror
                    </div>

                    <div class="form-group">
                        <label>Kategori</label>
                        <select name="category_id" class="form-control">
                            <option value="">-- Pilih Kategori --</option>
                            @foreach ($categories as $cat)
                                <option value="{{ $cat->id }}"
                                    {{ old('category_id', $product->category_id) == $cat->id ? 'selected' : '' }}>
                                    {{ $cat->nama_barang }}
                                </option>
                            @endforeach
                        </select>
                        @error('category_id')<div class="text-danger">{{ $message }}</div>@enderror
                    </div>

                    <div class="form-group">
                        <label>Stok</label>
                        <input type="number" name="stok_barang" class="form-control"
                            value="{{ old('stok_barang', $product->stok_barang ?? 0) }}">
                        @error('stok_barang')<div class="text-danger">{{ $message }}</div>@enderror
                    </div>

                    <button type="submit" class="btn btn-primary">Update</button>
                    <a href="{{ route('user.products.index') }}" class="btn btn-secondary">Batal</a>
                </form>
            </div>
        </div>
    </div
