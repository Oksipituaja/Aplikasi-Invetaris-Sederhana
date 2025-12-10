{{-- Gunakan Layout User agar tampilan konsisten --}}
@extends('layouts.user')

@section('title', 'Daftar Barang Saya')

@section('content')
<div class="container py-3">
    {{-- Alert jika ada pesan sukses --}}
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    {{-- Tombol tambah produk --}}
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4>Daftar Barang Inventaris</h4>
        <a href="{{ route('user.products.create') }}" class="btn btn-success">
            <i class="fas fa-plus"></i> Tambah Produk
        </a>
    </div>

    {{-- Tabel produk --}}
    <div class="card shadow-sm border-0">
        <div class="card-body">
            @if ($products->count())
                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>Nama Barang</th>
                                <th>Kategori</th>
                                <th>NUP/Ruangan</th>
                                <th>Stok</th>
                                <th>Mulai</th>
                                <th>Selesai</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($products as $product)
                            <tr>
                                <td>
                                    <strong>{{ $product->nama_barang }}</strong><br>
                                    <small class="text-muted">{{ $product->description ?? '' }}</small>
                                </td>
                                <td><span class="badge bg-secondary">{{ $product->category->nama_barang ?? '-' }}</span></td>
                                <td>{{ $product->nup_ruangan ?? '-' }}</td>
                                <td>
                                    {{ $product->stok_barang }}
                                    @if($product->stok_barang < 5)
                                        <span class="badge bg-danger ms-1">Menipis</span>
                                    @endif
                                </td>
                                <td>
                                    {{ $product->tanggal_mulai ? $product->tanggal_mulai->format('d M Y') : '-' }}
                                </td>
                                <td>
                                    {{ $product->tanggal_selesai ? $product->tanggal_selesai->format('d M Y') : '-' }}
                                </td>
                                <td>
                                    <div class="btn-group btn-group-sm">
                                        <a href="{{ route('user.products.edit', $product->id) }}" class="btn btn-warning text-white">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ route('user.products.destroy', $product->id) }}" method="POST" class="d-inline" 
                                            onsubmit="return confirm('Yakin ingin menghapus produk ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn btn-danger"><i class="fas fa-trash"></i></button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="alert alert-info text-center">
                    Belum ada produk yang ditambahkan. Silakan tambah produk baru.
                </div>
            @endif
        </div>
    </div>
</div>
@endsection