@extends('layouts.main')

@section('header')
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1><i class="fas fa-box me-2"></i> {{ isset($product) ? 'Edit Produk' : 'Tambah Produk Baru' }}</h1>
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
    <div class="col-lg-12">
        <div class="card card-primary card-outline">
            <div class="card-body">
                <form action="{{ isset($product) ? route('admin.products.update', $product->id) : route('admin.products.store') }}" 
                      method="POST" 
                      enctype="multipart/form-data">
                    @csrf
                    @if (isset($product))
                        @method('PUT')
                    @endif

                    {{-- Bagian Penanggung Jawab --}}
                    <h5 class="mt-2 mb-3 text-primary"><i class="fas fa-user-tie me-1"></i> Detail Penanggung Jawab</h5>
                    
                    <div class="form-group">
                        <label for="user_id">Penanggung Jawab (User Sistem)</label>
                        {{-- Field ini harusnya opsional jika admin ingin mengisi manual di bawah --}}
                        <select name="user_id" id="user_id" class="form-control select2 @error('user_id') is-invalid @enderror" data-placeholder="Pilih User">
                            <option value="">-- PILIH USER (OPSIONAL) --</option>
                            @foreach ($users as $user) 
                                <option value="{{ $user->id }}" 
                                    {{ old('user_id', $product->user_id ?? '') == $user->id ? 'selected' : '' }}>
                                    {{ $user->name }} ({{ $user->email }})
                                </option>
                            @endforeach
                        </select>
                         @error('user_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                         <small class="form-text text-muted">Jika user dipilih, data di bawah akan diisi berdasarkan data user.</small>
                    </div>

                    <div class="form-group">
                        <label for="nama_lengkap">Nama Lengkap</label>
                        <input type="text" name="nama_lengkap" id="nama_lengkap" class="form-control @error('nama_lengkap') is-invalid @enderror"
                               value="{{ old('nama_lengkap', $product->nama_lengkap ?? '') }}">
                         @error('nama_lengkap')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="row">
                        <div class="col-md-4 form-group">
                            <label for="nim">NIM</label>
                            <input type="text" name="nim" id="nim" class="form-control @error('nim') is-invalid @enderror"
                                   value="{{ old('nim', $product->nim ?? '') }}">
                            @error('nim')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        
                        <div class="col-md-4 form-group">
                            <label for="prodi">Prodi</label>
                            <select name="prodi" id="prodi" class="form-control @error('prodi') is-invalid @enderror">
                                <option value="">-- Pilih Prodi --</option>
                                @php
                                    $prodis = ['Teknik Informatika','Sistem Informasi','Manajemen','Akuntansi','Pendidikan', 'Lainnya'];
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
                            <label for="phone_number">Nomor HP</label>
                            <input type="text" name="phone_number" id="phone_number" class="form-control @error('phone_number') is-invalid @enderror"
                                   value="{{ old('phone_number', $product->phone_number ?? '') }}">
                            @error('phone_number')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="photo">Foto Penanggung Jawab (Opsional)</label>
                        @if (isset($product) && $product->photo_path)
                            <div class="mb-2">
                                <a href="{{ Storage::url($product->photo_path) }}">
                                <img src="{{ Storage::url($product->photo_path) }}" 
                                     alt="Foto Lama" 
                                     style="width: 100px; height: 100px; object-fit: cover; border-radius: 5px; border: 1px solid #ddd;">    
                                </a>
                                <small class="text-muted d-block">Foto lama. Biarkan kosong jika tidak ingin diubah.</small>
                            </div>
                        @endif
                        <input type="file" name="photo" id="photo" class="form-control @error('photo') is-invalid @enderror" accept="image/*">
                        @error('photo')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    
                    <hr>
                    
                    {{-- Bagian Detail Barang --}}
                    <h5 class="mt-4 mb-3 text-success"><i class="fas fa-boxes me-1"></i> Detail Barang Inventaris</h5>
                    
                    <div class="form-group">
                        <label for="nama_barang">Nama Barang *</label>
                        <input type="text" name="nama_barang" id="nama_barang" class="form-control @error('nama_barang') is-invalid @enderror" required
                               value="{{ old('nama_barang', $product->nama_barang ?? '') }}">
                         @error('nama_barang')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    
                    <div class="form-group">
                        <label for="description">Keterangan / Deskripsi</label>
                        <textarea name="description" id="description" class="form-control @error('description') is-invalid @enderror" rows="3">{{ old('description', $product->description ?? '') }}</textarea>
                         @error('description')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="row">
                        <div class="col-md-6 form-group">
                            <label for="nup_ruangan">NUP/Ruangan</label>
                            <input type="text" name="nup_ruangan" id="nup_ruangan" class="form-control @error('nup_ruangan') is-invalid @enderror"
                                   value="{{ old('nup_ruangan', $product->nup_ruangan ?? '') }}">
                            @error('nup_ruangan')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-6 form-group">
                            <label for="stok_barang">Stok *</label>
                            <input type="number" name="stok_barang" id="stok_barang" class="form-control @error('stok_barang') is-invalid @enderror" required
                                   value="{{ old('stok_barang', $product->stok_barang ?? 1) }}" min="1">
                            @error('stok_barang')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6 form-group">
                            <label for="tanggal_mulai">Tanggal Mulai Digunakan *</label>
                            <input type="date" name="tanggal_mulai" id="tanggal_mulai" class="form-control @error('tanggal_mulai') is-invalid @enderror" required
                                   value="{{ old('tanggal_mulai', isset($product) && $product->tanggal_mulai ? \Carbon\Carbon::parse($product->tanggal_mulai)->format('Y-m-d') : now()->format('Y-m-d')) }}">
                            @error('tanggal_mulai')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div class="col-md-6 form-group">
                            <label for="tanggal_selesai">Tanggal Selesai (Opsional)</label>
                            <input type="date" name="tanggal_selesai" id="tanggal_selesai" class="form-control @error('tanggal_selesai') is-invalid @enderror"
                                   value="{{ old('tanggal_selesai', isset($product) && $product->tanggal_selesai ? \Carbon\Carbon::parse($product->tanggal_selesai)->format('Y-m-d') : '') }}">
                            @error('tanggal_selesai')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label for="category_id">Kategori *</label>
                        <select name="category_id" id="category_id" class="form-control @error('category_id') is-invalid @enderror" required>
                            <option value="">-- Pilih Kategori --</option>
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}"
                                    {{ old('category_id', $product->category_id ?? '') == $category->id ? 'selected' : '' }}>
                                    {{ $category->nama_kategori ?? $category->name ?? $category->nama_barang }}
                                </option>
                            @endforeach
                        </select>
                        @error('category_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="pt-3 border-top">
                        <button type="submit" class="btn btn-primary"><i class="fas fa-save me-1"></i> {{ isset($product) ? 'Update Data' : 'Simpan Barang' }}</button>
                        <a href="{{ route('admin.products.index') }}" class="btn btn-secondary">Batal</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
