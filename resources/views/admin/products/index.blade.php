@extends('layouts.main')

@section('header')
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1>{{ isset($product) ? 'Edit Produk' : 'Tambah Produk' }}</h1>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Beranda</a></li>
                <li class="breadcrumb-item"><a href="{{ route('admin.products.index') }}">Produk</a></li>
                <li class="breadcrumb-item active">{{ isset($product) ? 'Edit' : 'Tambah' }}</li>
            </ol>
        </div>
    </div>
@endsection

@section('content')
    <div class="row">
        <div class="col">
            <div class="card">
                <div class="card-body">
                    <form
                        action="{{ isset($product) ? route('admin.products.update', $product->id) : route('admin.products.store') }}"
                        method="POST">
                        @csrf
                        @if (isset($product))
                            @method('PUT')
                        @endif

                        {{-- Tambahan field identitas --}}
                        <div class="form-group">
                            <label>Nama Lengkap</label>
                            <input type="text" name="nama_lengkap" class="form-control"
                                value="{{ old('nama_lengkap', $product->nama_lengkap ?? '') }}">
                            @error('nama_lengkap')<div class="text-danger">{{ $message }}</div>@enderror
                        </div>

                        <div class="form-group">
                            <label>NIM</label>
                            <input type="text" name="nim" class="form-control"
                                value="{{ old('nim', $product->nim ?? '') }}">
                            @error('nim')<div class="text-danger">{{ $message }}</div>@enderror
                        </div>

                        <div class="form-group">
                            <label>Program Studi</label>
                            <input type="text" name="prodi" class="form-control"
                                value="{{ old('prodi', $product->prodi ?? '') }}">
                            @error('prodi')<div class="text-danger">{{ $message }}</div>@enderror
                        </div>

                        {{-- Field produk --}}
                        <div class="form-group">
                            <label>Nama Barang</label>
                            <input type="text" name="nama_barang" class="form-control"
                                value="{{ old('nama_barang', $product->nama_barang ?? '') }}">
                            @error('nama_barang')<div class="text-danger">{{ $message }}</div>@enderror
                        </div>

                        <div class="form-group">
                            <label>Keterangan</label>
                            <textarea name="description" class="form-control">{{ old('description', $product->description ?? '') }}</textarea>
                        </div>

                        <div class="form-group">
                            <label>NUP/Ruangan</label>
                            <input type="text" name="nup_ruangan" class="form-control"
                                value="{{ old('nup_ruangan', $product->nup_ruangan ?? '') }}">
                            @error('nup_ruangan')<div class="text-danger">{{ $message }}</div>@enderror
                        </div>

                        <div class="form-group">
                            <label>Tanggal Mulai</label>
                            <input type="date" name="tanggal_mulai" class="form-control"
                                value="{{ old('tanggal_mulai', $product->tanggal_mulai ?? '') }}">
                        </div>

                        <div class="form-group">
                            <label>Tanggal Selesai</label>
                            <input type="date" name="tanggal_selesai" class="form-control"
                                value="{{ old('tanggal_selesai', $product->tanggal_selesai ?? '') }}">
                        </div>

                        @if (isset($categories))
                            <div class="form-group">
                                <label>Kategori</label>
                                <select name="category_id" class="form-control">
                                    <option value="">-- Pilih Kategori Kerusakan --</option>
                                    @foreach ($categories as $category)
                                        <option value="{{ $category->id }}"
                                            {{ old('category_id', $product->category_id ?? '') == $category->id ? 'selected' : '' }}>
                                            {{ $category->nama_barang }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('category_id')<div class="text-danger">{{ $message }}</div>@enderror
                            </div>
                        @endif

                        <div class="form-group">
                            <label>Stok</label>
                            <input type="number" name="stok_barang" class="form-control"
                                value="{{ old('stok_barang', $product->stok_barang ?? '') }}">
                            @error('stok_barang')<div class="text-danger">{{ $message }}</div>@enderror
                        </div>

                        <button type="submit" class="btn btn-primary">{{ isset($product) ? 'Update' : 'Simpan' }}</button>
                        <a href="{{ route('admin.products.index') }}" class="btn btn-secondary">Batal</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
