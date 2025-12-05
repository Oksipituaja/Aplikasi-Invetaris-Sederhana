@extends('layouts.main')

@section('header')
    <h1>Daftar Barang Inventaris</h1>
@endsection

@section('content')
<div class="container py-3">
    {{-- Alert jika ada pesan sukses --}}
    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    {{-- Tombol tambah produk --}}
    <div class="text-end mb-3">
        <a href="{{ route('user.products.create') }}" class="btn btn-success">
            + Tambah Produk
        </a>
    </div>

    {{-- Tabel produk --}}
    @if ($products->count())
        <div class="table-responsive">
            <table class="table table-bordered table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th>Nama Lengkap</th>
                        <th>NIM</th>
                        <th>Prodi</th>
                        <th>Nama Barang</th>
                        <th>Keterangan</th>
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
                        <td>{{ $product->nama_lengkap ?? '-' }}</td>
                        <td>{{ $product->nim ?? '-' }}</td>
                        <td>{{ $product->prodi ?? '-' }}</td>
                        <td>{{ $product->nama_barang }}</td>
                        <td>{{ $product->description }}</td>
                        <td>{{ $product->category->nama_barang ?? '-' }}</td>
                        <td>{{ $product->nup_ruangan ?? '-' }}</td>
                        <td>
                            {{ $product->stok_barang }}
                            @if($product->stok_barang < 5)
                                <span class="badge bg-danger ms-1">Stok Menipis</span>
                            @endif
                        </td>
                        <td>
                            {{ $product->tanggal_mulai 
                                ? $product->tanggal_mulai->timezone('Asia/Jakarta')->format('d M Y H:i') 
                                : '-' }}
                        </td>
                        <td>
                            {{ $product->tanggal_selesai 
                                ? $product->tanggal_selesai->timezone('Asia/Jakarta')->format('d M Y H:i') 
                                : '-' }}
                        </td>
                        <td>
                            <a href="{{ route('user.products.edit', $product->id) }}" class="btn btn-sm btn-warning">
                                ✏️ Edit
                            </a>
                            <form action="{{ route('user.products.destroy', $product->id) }}" method="POST" class="d-inline" 
                                onsubmit="return confirm('Yakin ingin menghapus produk ini?')">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-sm btn-danger">🗑️ Hapus</button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @else
        <div class="alert alert-info">Belum ada produk yang ditambahkan.</div>
    @endif
</div>
@endsection
