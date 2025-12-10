@extends('layouts.main')

@section('header')
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1><i class="fas fa-boxes me-2"></i> Daftar Produk Inventaris</h1>
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
    <div class="col-12">
        <div class="card card-outline card-primary">
            <div class="card-header">
                 <a href="{{ route('admin.products.create') }}" class="btn btn-success">
                    <i class="fas fa-plus"></i> Tambah Produk
                </a>
                <div class="card-tools">
                    <form method="GET" action="{{ route('admin.products.index') }}">
                        <div class="input-group input-group-sm" style="width: 250px;">
                            <select name="category_id" class="form-control float-right" onchange="this.form.submit()">
                                <option value="">-- Filter Kategori --</option>
                                @foreach ($categories as $cat)
                                    <option value="{{ $cat->id }}" {{ request('category_id') == $cat->id ? 'selected' : '' }}>
                                        {{ $cat->nama_kategori ?? $cat->nama_barang }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </form>
                </div>
            </div>
            <div class="card-body">

                @if (session('success'))
                    <div class="alert alert-success alert-dismissible fade show" id="success-alert">
                        {{ session('success') }}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                @endif

                <div class="table-responsive">
                    <table class="table table-bordered table-striped table-sm align-middle">
                        <thead class="bg-dark">
                            <tr>
                                <th>No</th>
                                <th>Barang</th>
                                <th>Kategori</th>
                                <th class="text-center">Stok</th>
                                <th>Penanggung Jawab (PJ)</th>
                                <th>PJ Detail</th>
                                <th>NUP/Ruangan</th>
                                <th>Periode</th>
                                <th style="width: 100px;">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($products as $product)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>
                                        <strong>{{ $product->nama_barang }}</strong><br>
                                        <small class="text-muted">{{ $product->description ? \Illuminate\Support\Str::limit($product->description, 30) : 'Tanpa Keterangan' }}</small>
                                    </td>
                                    <td>
                                        <span class="badge bg-info">{{ $product->category->nama_kategori ?? $product->category->nama_barang ?? '-' }}</span>
                                    </td>
                                    <td class="text-center">
                                        {{ $product->stok_barang ?? 0 }}
                                        @if($product->stok_barang < 5)
                                            <span class="badge bg-danger ms-1" title="Stok Menipis">Rendah</span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            @if ($product->photo_path)
                                                <img src="{{ Storage::url($product->photo_path) }}" alt="Foto PJ" 
                                                     class="img-circle me-2" style="width: 35px; height: 35px; object-fit: cover;">
                                            @else
                                                <i class="fas fa-user-circle fa-2x text-muted me-2"></i>
                                            @endif
                                            <strong>{{ $product->nama_lengkap ?? 'Unknown' }}</strong>
                                        </div>
                                    </td>
                                    <td>
                                        <small>NIM: {{ $product->nim ?? '-' }}</small><br>
                                        <small>Prodi: {{ $product->prodi ?? '-' }}</small>
                                    </td>
                                    <td>{{ $product->nup_ruangan ?? '-' }}</td>
                                    <td>
                                        <small>Mulai: {{ $product->tanggal_mulai ? \Carbon\Carbon::parse($product->tanggal_mulai)->format('d/m/Y') : '-' }}</small><br>
                                        <small>Selesai: {{ $product->tanggal_selesai ? \Carbon\Carbon::parse($product->tanggal_selesai)->format('d/m/Y') : 'Tidak Ditentukan' }}</small>
                                    </td>
                                    <td>
                                        <div class="btn-group btn-group-sm" role="group">
                                            <a href="{{ route('admin.products.edit', $product->id) }}" 
                                               class="btn btn-warning btn-sm text-white" title="Edit">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <form action="{{ route('admin.products.destroy', $product->id) }}" 
                                                  method="POST" style="display:inline;" onsubmit="return confirm('Yakin ingin menghapus produk {{ $product->nama_barang }}?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm" title="Hapus">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="9" class="text-center">
                                        <i class="fas fa-info-circle me-1"></i> Tidak ada data produk yang ditemukan.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                {{-- Tambahkan link paginasi jika menggunakan pagination --}}
                {{-- <div class="mt-3">
                    {{ $products->links() }}
                </div> --}}
            </div>
        </div>
    </div>
</div>
@endsection
