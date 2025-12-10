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
                <form action="{{ isset($product) ? route('admin.products.update', $product->id) : route('admin.products.store') }}" 
                      method="POST" 
                      enctype="multipart/form-data">
                    @csrf
                    @if (isset($product))
                        @method('PUT')
                    @endif

                    <h5 class="mt-2 mb-3">Detail Penanggung Jawab</h5>
                    
                    <div class="form-group">
                        <label>Penanggung Jawab (User)</label>
                        <select name="user_id" class="form-control @error('user_id') is-invalid @enderror">
                            <option value="">-- Pilih User Penanggung Jawab --</option>
                            @foreach ($users as $user) 
                                <option value="{{ $user->id }}" 
                                    {{ old('user_id', $product->user_id ?? '') == $user->id ? 'selected' : '' }}>
                                    {{ $user->name }} ({{ $user->email }})
                                </option>
                            @endforeach
                        </select>
                         @error('user_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="form-group">
                        <label>Nama Lengkap</label>
                        <input type="text" name="nama_lengkap" class="form-control @error('nama_lengkap') is-invalid @enderror"
                               value="{{ old('nama_lengkap', $product->nama_lengkap ?? '') }}">
                         @error('nama_lengkap')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="row">
                        <div class="col-md-4 form-group">
                            <label>NIM</label>
                            <input type="text" name="nim" class="form-control @error('nim') is-invalid @enderror"
                                   value="{{ old('nim', $product->nim ?? '') }}">
                            @error('nim')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        
                        <div class="col-md-4 form-group">
                            <label>Prodi</label>
                            <select name="prodi" class="form-control @error('prodi') is-invalid @enderror">
                                <option value="">-- Pilih Prodi --</option>
                                @php
                                    $prodis = ['Teknik Informatika','Sistem Informasi','Manajemen','Akuntansi','Pendidikan'];
                                @endphp
                                @foreach ($prodis as $p)
                                    <option value="{{ $p }}" {{ old('prodi', $product->prodi ?? '') == $p ? 'selected' : '' }}>
                                        {{ $p }}
                                    </option>
                                @endforeach
                            </select>
                            @error('prodi')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        
                        <div class="col-md-4 form-group">
                            <label>Nomor HP</label>
                            <input type="text" name="phone_number" class="form-control @error('phone_number') is-invalid @enderror"
                                   value="{{ old('phone_number', $product->phone_number ?? '') }}">
                            @error('phone_number')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                    </div>

                    <div class="form-group">
                        <label>Foto Penanggung Jawab (Opsional)</label>
                        @if (isset($product) && $product->photo_path)
                            <div class="mb-2">
                                <img src="{{ Storage::url($product->photo_path) }}" alt="Foto Lama" 
                                     style="width: 80px; height: 80px; object-fit: cover; border-radius: 5px;">
                                <small class="text-muted d-block">Biarkan kosong jika tidak ingin diubah.</small>
                            </div>
                        @endif
                        <input type="file" name="photo" class="form-control @error('photo') is-invalid @enderror">
                        @error('photo')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    
                    <hr>
                    <h5 class="mt-4 mb-3">Detail Barang</h5>
                    
                    <div class="form-group">
                        <label>Nama Barang</label>
                        <input type="text" name="nama_barang" class="form-control @error('nama_barang') is-invalid @enderror"
                               value="{{ old('nama_barang', $product->nama_barang ?? '') }}">
                         @error('nama_barang')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    
                    <div class="form-group">
                        <label>Keterangan</label>
                        <textarea name="description" class="form-control @error('description') is-invalid @enderror">{{ old('description', $product->description ?? '') }}</textarea>
                         @error('description')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="row">
                        <div class="col-md-6 form-group">
                            <label>NUP/Ruangan</label>
                            <input type="text" name="nup_ruangan" class="form-control @error('nup_ruangan') is-invalid @enderror"
                                   value="{{ old('nup_ruangan', $product->nup_ruangan ?? '') }}">
                            @error('nup_ruangan')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-6 form-group">
                            <label>Stok</label>
                            <input type="number" name="stok_barang" class="form-control @error('stok_barang') is-invalid @enderror"
                                   value="{{ old('stok_barang', $product->stok_barang ?? 0) }}">
                            @error('stok_barang')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6 form-group">
                            <label>Tanggal Mulai</label>
                            <input type="date" name="tanggal_mulai" class="form-control @error('tanggal_mulai') is-invalid @enderror"
                                   value="{{ old('tanggal_mulai', isset($product) && $product->tanggal_mulai ? $product->tanggal_mulai->format('Y-m-d') : '') }}">
                            @error('tanggal_mulai')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div class="col-md-6 form-group">
                            <label>Tanggal Selesai</label>
                            <input type="date" name="tanggal_selesai" class="form-control @error('tanggal_selesai') is-invalid @enderror"
                                   value="{{ old('tanggal_selesai', isset($product) && $product->tanggal_selesai ? $product->tanggal_selesai->format('Y-m-d') : '') }}">
                            @error('tanggal_selesai')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label>Kategori</label>
                        <select name="category_id" class="form-control @error('category_id') is-invalid @enderror">
                            <option value="">-- Pilih Kategori --</option>
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}"
                                    {{ old('category_id', $product->category_id ?? '') == $category->id ? 'selected' : '' }}>
                                    {{ $category->nama_barang }}
                                </option>
                            @endforeach
                        </select>
                        @error('category_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>


                    <button type="submit" class="btn btn-primary">{{ isset($product) ? 'Update' : 'Simpan' }}</button>
                    <a href="{{ route('admin.products.index') }}" class="btn btn-secondary">Batal</a>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection