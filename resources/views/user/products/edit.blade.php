@extends('layouts.app')

@section('title', 'Edit Barang: ' . $product->nama_barang)

@section('content')
<div class="container py-3">
    <h4>Edit Barang: **{{ $product->nama_barang }}**</h4>
    
    <form action="{{ route('user.products.update', $product->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="card shadow-sm border-0 mb-3">
            <div class="card-header bg-primary text-white">Detail Penanggung Jawab</div>
            <div class="card-body">
                <div class="mb-3">
                    <label for="nama_lengkap" class="form-label">Nama Lengkap</label>
                    <input type="text" class="form-control @error('nama_lengkap') is-invalid @enderror" id="nama_lengkap" name="nama_lengkap" value="{{ old('nama_lengkap', $product->nama_lengkap) }}" required>
                    @error('nama_lengkap')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="nim" class="form-label">NIM</label>
                        <input type="text" class="form-control @error('nim') is-invalid @enderror" id="nim" name="nim" value="{{ old('nim', $product->nim) }}" required>
                        @error('nim')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="prodi" class="form-label">Program Studi (Prodi)</label>
                        <select class="form-select @error('prodi') is-invalid @enderror" id="prodi" name="prodi" required>
                            <option value="">Pilih Program Studi</option>
                            @php
                                $prodiList = ['Teknik Informatika', 'Sistem Informasi', 'Manajemen', 'Akuntansi', 'Hukum'];
                            @endphp
                            @foreach ($prodiList as $prodiName)
                                <option value="{{ $prodiName }}" {{ old('prodi', $product->prodi) == $prodiName ? 'selected' : '' }}>
                                    {{ $prodiName }}
                                </option>
                            @endforeach
                        </select>
                        @error('prodi')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                </div>

                <div class="mb-3">
                    <label for="phone_number" class="form-label">Nomor HP/Telepon</label>
                    <input type="text" class="form-control @error('phone_number') is-invalid @enderror" id="phone_number" name="phone_number" value="{{ old('phone_number', $product->phone_number) }}" required>
                    @error('phone_number')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                
                <div class="mb-3">
                    <label for="photo" class="form-label">Foto Penanggung Jawab (Ganti)</label>
                    @if ($product->photo_path)
                        <div class="mb-2">
                            <small class="d-block text-muted">Foto saat ini:</small>
                             <a href="{{ Storage::url($product->photo_path) }}">
                            <img src="{{ Storage::url($product->photo_path) }}" 
                                 alt="Foto saat ini" 
                                 style="width: 100px; height: 100px; object-fit: cover; border-radius: 5px;">
                             </a>
                        </div>
                    @endif
                    <input class="form-control @error('photo') is-invalid @enderror" type="file" id="photo" name="photo" 
                           accept="image/*">
                    <small class="form-text text-muted">Unggah foto baru untuk mengganti foto lama. Maksimal 2MB.</small>
                    @error('photo')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

            </div>
        </div>

        <div class="card shadow-sm border-0">
            <div class="card-header bg-success text-white">Detail Barang</div>
            <div class="card-body">
                <div class="mb-3">
                    <label for="nama_barang" class="form-label">Nama Barang</label>
                    <input type="text" class="form-control @error('nama_barang') is-invalid @enderror" id="nama_barang" name="nama_barang" value="{{ old('nama_barang', $product->nama_barang) }}" required>
                    @error('nama_barang')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="category_id" class="form-label">Kategori</label>
                        <select class="form-select @error('category_id') is-invalid @enderror" id="category_id" name="category_id" required>
                            <option value="">Pilih Kategori</option>
                            @if(isset($categories))
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}" {{ old('category_id', $product->category_id) == $category->id ? 'selected' : '' }}>
                                        {{ $category->nama_barang }}
                                    </option>
                                @endforeach
                            @endif
                        </select>
                        @error('category_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="stok_barang" class="form-label">Stok Barang</label>
                        <input type="number" class="form-control @error('stok_barang') is-invalid @enderror" id="stok_barang" name="stok_barang" value="{{ old('stok_barang', $product->stok_barang) }}" min="1" required>
                        @error('stok_barang')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                </div>
                
                <div class="mb-3">
                    <label for="nup_ruangan" class="form-label">NUP / Ruangan</label>
                    <input type="text" class="form-control @error('nup_ruangan') is-invalid @enderror" id="nup_ruangan" name="nup_ruangan" value="{{ old('nup_ruangan', $product->nup_ruangan) }}">
                    @error('nup_ruangan')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="mb-3">
                    <label for="description" class="form-label">Deskripsi / Keterangan</label>
                    <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description">{{ old('description', $product->description) }}</textarea>
                    @error('description')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="tanggal_mulai" class="form-label">Tanggal Mulai Digunakan</label>
                        <input type="date" class="form-control @error('tanggal_mulai') is-invalid @enderror" id="tanggal_mulai" name="tanggal_mulai" value="{{ old('tanggal_mulai', $product->tanggal_mulai ? $product->tanggal_mulai->format('Y-m-d') : '') }}">
                        @error('tanggal_mulai')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="tanggal_selesai" class="form-label">Tanggal Selesai (Opsional)</label>
                        <input type="date" class="form-control @error('tanggal_selesai') is-invalid @enderror" id="tanggal_selesai" name="tanggal_selesai" value="{{ old('tanggal_selesai', $product->tanggal_selesai ? $product->tanggal_selesai->format('Y-m-d') : '') }}">
                        @error('tanggal_selesai')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                </div>

                <div class="d-flex justify-content-end">
                    <a href="{{ route('user.products.index') }}" class="btn btn-secondary me-2">Batal</a>
                    <button type="submit" class="btn btn-warning text-white">Update Barang</button>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection
