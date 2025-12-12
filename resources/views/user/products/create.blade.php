@extends('layouts.app') 

@section('title', 'Tambah Barang Baru')

@section('content')
<div class="container py-4">
    <h4 class="mb-3">Tambah Barang Baru</h4>
    <p class="text-muted">Isi detail penanggung jawab dan informasi barang yang akan diinventarisasi.</p>
    
    <form action="{{ route('user.products.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        {{-- Detail Penanggung Jawab Card --}}
        <div class="card shadow-sm border-0 mb-4">
            <div class="card-header bg-primary text-white">
                <i class="fas fa-user-tag me-2"></i> Detail Penanggung Jawab
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <label for="nama_lengkap" class="form-label">Nama Lengkap <span class="text-danger">*</span></label>
                    <input type="text" class="form-control @error('nama_lengkap') is-invalid @enderror" id="nama_lengkap" name="nama_lengkap" value="{{ old('nama_lengkap') }}" required>
                    @error('nama_lengkap')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="nim" class="form-label">NIM <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('nim') is-invalid @enderror" id="nim" name="nim" value="{{ old('nim') }}" required>
                        @error('nim')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    
                    <div class="col-md-6 mb-3">
                        <label for="prodi" class="form-label">Program Studi (Prodi) <span class="text-danger">*</span></label>
                        <select class="form-select @error('prodi') is-invalid @enderror" id="prodi" name="prodi" required>
                            <option value="">Pilih Program Studi</option>
                            @php
                                // Daftar Prodi (Contoh Hardcoded)
                                $prodiList = ['Teknik Informatika', 'Sistem Informasi', 'Manajemen', 'Akuntansi', 'Hukum', 'Lainnya'];
                            @endphp
                            @foreach ($prodiList as $prodiName)
                                <option value="{{ $prodiName }}" {{ old('prodi') == $prodiName ? 'selected' : '' }}>
                                    {{ $prodiName }}
                                </option>
                            @endforeach
                        </select>
                        @error('prodi')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                </div>
                
                <div class="mb-3">
                    <label for="phone_number" class="form-label">Nomor HP/Telepon <span class="text-danger">*</span></label>
                    < type="text" class="form-control @error('phone_number') is-invalid @enderror" id="phone_number" name="phone_number" value="{{ old('phone_number') }}" required>
                    @error('phone_number')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                
                <div class="mb-0">
                    <label for="photo" class="form-label">Foto Penanggung Jawab (Opsional)</label>
                    <input class="form-control @error('photo') is-invalid @enderror" type="file" id="photo" name="photo" 
                            accept="image/*" 
                    <small class="form-text text-muted">Maksimal 2MB. Disarankan foto yang jelas.</small>
                    @error('photo')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
            </div>
        </div>
        
        {{-- Detail Barang Card --}}
        <div class="card shadow-sm border-0 mb-4">
            <div class="card-header bg-success text-white">
                <i class="fas fa-boxes me-2"></i> Detail Barang Inventaris
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <label for="nama_barang" class="form-label">Nama Barang <span class="text-danger">*</span></label>
                    <input type="text" class="form-control @error('nama_barang') is-invalid @enderror" id="nama_barang" name="nama_barang" value="{{ old('nama_barang') }}" required>
                    @error('nama_barang')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="category_id" class="form-label">Kategori <span class="text-danger">*</span></label>
                        {{-- Asumsi $categories adalah Collection atau Array dari Category Model --}}
                        <select class="form-select @error('category_id') is-invalid @enderror" id="category_id" name="category_id" required>
                            <option value="">Pilih Kategori</option>
                            @if(isset($categories) && count($categories) > 0)
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                        {{ $category->nama_kategori ?? $category->name ?? $category->nama_barang }} 
                                        {{-- Menggunakan nama_kategori/name sebagai fallback --}}
                                    </option>
                                @endforeach
                            @else
                                <option value="" disabled>Belum ada kategori tersedia</option>
                            @endif
                        </select>
                        @error('category_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="stok_barang" class="form-label">Stok Barang <span class="text-danger">*</span></label>
                        <input type="number" class="form-control @error('stok_barang') is-invalid @enderror" id="stok_barang" name="stok_barang" value="{{ old('stok_barang', 1) }}" min="1" required>
                        @error('stok_barang')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                </div>
                
                <div class="mb-3">
                    <label for="nup_ruangan" class="form-label">NUP / Ruangan <span class="text-danger">*</span></label>
                    <input type="text" class="form-control @error('nup_ruangan') is-invalid @enderror" id="nup_ruangan" name="nup_ruangan" value="{{ old('nup_ruangan') }}">
                    @error('nup_ruangan')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="mb-3">
                    <label for="description" class="form-label">Deskripsi / Keterangan (Opsional)</label>
                    <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description" rows="3">{{ old('description') }}</textarea>
                    @error('description')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="tanggal_mulai" class="form-label">Tanggal Mulai Digunakan <span class="text-danger">*</span></label>
                        <input type="date" class="form-control @error('tanggal_mulai') is-invalid @enderror" id="tanggal_mulai" name="tanggal_mulai" value="{{ old('tanggal_mulai', now()->toDateString()) }}" required>
                        @error('tanggal_mulai')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="tanggal_selesai" class="form-label">Tanggal Selesai (Opsional)</label>
                        <input type="date" class="form-control @error('tanggal_selesai') is-invalid @enderror" id="tanggal_selesai" name="tanggal_selesai" value="{{ old('tanggal_selesai') }}">
                        @error('tanggal_selesai')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                </div>

                <div class="d-flex justify-content-end pt-3">
                    <a href="{{ route('user.products.index') }}" class="btn btn-secondary me-2">Batal</a>
                    <button type="submit" class="btn btn-success">
                        <i class="fas fa-save me-1"></i> Simpan Barang
                    </button>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection
