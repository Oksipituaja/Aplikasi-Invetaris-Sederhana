@extends('layouts.app')

@section('title', 'Edit Barang: ' . $product->nama_barang)

@section('content')
<div class="row">
    <div class="col-md-8 offset-md-2">
        <div class="card shadow-sm">
            <div class="card-header bg-warning text-dark">
                <h3 class="card-title">Form Edit Barang: {{ $product->nama_barang }}</h3>
            </div>
            <div class="card-body">
                <form action="{{ route('user.products.update', $product->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="form-group mb-3">
                        <label>Nama Lengkap</label>
                        <input type="text" name="nama_lengkap" class="form-control @error('nama_lengkap') is-invalid @enderror"
                            value="{{ old('nama_lengkap', $product->nama_lengkap) }}" required>
                        @error('nama_lengkap')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="form-group mb-3">
                        <label>NIM</label>
                        <input type="text" name="nim" class="form-control @error('nim') is-invalid @enderror"
                            value="{{ old('nim', $product->nim) }}" required>
                        @error('nim')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="form-group mb-3">
                        <label>Prodi</label>
                        <select name="prodi" class="form-control @error('prodi') is-invalid @enderror" required>
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
                        @error('prodi')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="form-group mb-3">
                        <label>Nama Barang</label>
                        <input type="text" name="nama_barang" class="form-control @error('nama_barang') is-invalid @enderror"
                            value="{{ old('nama_barang', $product->nama_barang) }}" required>
                        @error('nama_barang')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="form-group mb-3">
                        <label>Keterangan</label>
                        <textarea name="description" class="form-control @error('description') is-invalid @enderror">{{ old('description', $product->description) }}</textarea>
                        @error('description')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="form-group mb-3">
                        <label>NUP/Ruangan</label>
                        <input type="text" name="nup_ruangan" class="form-control @error('nup_ruangan') is-invalid @enderror"
                            value="{{ old('nup_ruangan', $product->nup_ruangan) }}">
                        @error('nup_ruangan')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="form-group mb-3">
                        <label>Tanggal Mulai</label>
                        <input type="date" name="tanggal_mulai" class="form-control @error('tanggal_mulai') is-invalid @enderror"
                            value="{{ old('tanggal_mulai', $product->tanggal_mulai ? $product->tanggal_mulai->format('Y-m-d') : '') }}">
                        @error('tanggal_mulai')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    
                    <div class="form-group mb-3">
                        <label>Tanggal Selesai</label>
                        <input type="date" name="tanggal_selesai" class="form-control @error('tanggal_selesai') is-invalid @enderror"
                            value="{{ old('tanggal_selesai', $product->tanggal_selesai ? $product->tanggal_selesai->format('Y-m-d') : '') }}">
                        @error('tanggal_selesai')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="form-group mb-3">
                        <label>Kategori</label>
                        <select name="category_id" class="form-control @error('category_id') is-invalid @enderror">
                            <option value="">-- Pilih Kategori --</option>
                            @isset($categories)
                                @foreach ($categories as $cat)
                                    <option value="{{ $cat->id }}"
                                        {{ old('category_id', $product->category_id) == $cat->id ? 'selected' : '' }}>
                                        {{ $cat->nama_barang }}
                                    </option>
                                @endforeach
                            @endisset
                        </select>
                        @error('category_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="form-group mb-4">
                        <label>Stok</label>
                        <input type="number" name="stok_barang" class="form-control @error('stok_barang') is-invalid @enderror"
                            value="{{ old('stok_barang', $product->stok_barang ?? 1) }}" min="1" required>
                        @error('stok_barang')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <button type="submit" class="btn btn-primary"><i class="fas fa-arrow-up-right-from-square me-1"></i> Update</button>
                    <a href="{{ route('user.products.index') }}" class="btn btn-secondary">Batal</a>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection