@extends('layouts.main')

@section('header')
    <h1>Tambah Produk</h1>
@endsection

@section('content')
<div class="row">
    <div class="col-md-8 offset-md-2">
        <div class="card shadow-sm">
            <div class="card-body">
                <form action="{{ route('user.products.store') }}" method="POST">
                    @csrf

                    <!-- Nama Lengkap -->
                    <div class="form-group">
                        <label>Nama Lengkap</label>
                        <input type="text" name="nama_lengkap" class="form-control" value="{{ old('nama_lengkap') }}" required>
                        @error('nama_lengkap')<div class="text-danger">{{ $message }}</div>@enderror
                    </div>

                    <!-- NIM -->
                    <div class="form-group">
                        <label>NIM</label>
                        <input type="text" name="nim" class="form-control" value="{{ old('nim') }}" required>
                        @error('nim')<div class="text-danger">{{ $message }}</div>@enderror
                    </div>

                    <!-- Prodi Dropdown -->
                    <div class="form-group">
                        <label>Prodi</label>
                        <select name="prodi" class="form-control" required>
                            <option value="">-- Pilih Prodi --</option>
                            <option value="TI" {{ old('prodi') == 'TI' ? 'selected' : '' }}>Teknik Informatika</option>
                            <option value="SI" {{ old('prodi') == 'SI' ? 'selected' : '' }}>Sistem Informasi</option>
                            <option value="MI" {{ old('prodi') == 'MI' ? 'selected' : '' }}>Manajemen Informatika</option>
                            <!-- tambahkan sesuai kebutuhan -->
                        </select>
                        @error('prodi')<div class="text-danger">{{ $message }}</div>@enderror
                    </div>

                    <!-- Nama Barang -->
                    <div class="form-group">
                        <label>Nama Barang</label>
                        <input type="text" name="nama_barang" class="form-control" value="{{ old('nama_barang') }}">
                        @error('nama_barang')<div class="text-danger">{{ $message }}</div>@enderror
                    </div>

                    <!-- Keterangan -->
                    <div class="form-group">
                        <label>Keterangan</label>
                        <textarea name="description" class="form-control">{{ old('description') }}</textarea>
                    </div>

                    <!-- NUP/Ruangan -->
                    <div class="form-group">
                        <label>NUP/Ruangan</label>
                        <input type="text" name="nup_ruangan" class="form-control" value="{{ old('nup_ruangan') }}">
                        @error('nup_ruangan')<div class="text-danger">{{ $message }}</div>@enderror
                    </div>

                    <!-- Tanggal Mulai -->
                    <div class="form-group">
                        <label>Tanggal Mulai</label>
                        <input type="datetime-local" name="tanggal_mulai" class="form-control" value="{{ old('tanggal_mulai') }}">
                    </div>

                    <!-- Tanggal Selesai -->
                    <div class="form-group">
                        <label>Tanggal Selesai</label>
                        <input type="datetime-local" name="tanggal_selesai" class="form-control" value="{{ old('tanggal_selesai') }}">
                    </div>

                    <!-- Kategori -->
                    <div class="form-group">
                        <label>Kategori</label>
                        <select name="category_id" class="form-control">
                            <option value="">-- Pilih Kategori --</option>
                            @foreach ($categories as $cat)
                                <option value="{{ $cat->id }}" {{ old('category_id') == $cat->id ? 'selected' : '' }}>
                                    {{ $cat->nama_barang }}
                                </option>
                            @endforeach
                        </select>
                        @error('category_id')<div class="text-danger">{{ $message }}</div>@enderror
                    </div>

                    <!-- Stok -->
                    <div class="form-group">
                        <label>Stok</label>
                        <input type="number" name="stok_barang" class="form-control" value="{{ old('stok_barang') }}">
                        @error('stok_barang')<div class="text-danger">{{ $message }}</div>@enderror
                    </div>

                    <button type="submit" class="btn btn-primary">Simpan</button>
                    <a href="{{ route('user.home') }}" class="btn btn-secondary">Batal</a>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
