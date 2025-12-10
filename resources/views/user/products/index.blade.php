@extends('layouts.app') 

@section('title', 'Daftar Barang Saya')

@section('content')
<div class="container py-4">

    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4><i class="fas fa-clipboard-list me-2"></i> Daftar Barang Inventaris Saya</h4>
        <a href="{{ route('user.products.create') }}" class="btn btn-success">
            <i class="fas fa-plus"></i> Tambah Barang Baru
        </a>
    </div>

    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="card shadow-sm border-0">
        <div class="card-body">
            @if (isset($products) && $products->count())
                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>Nama Barang</th>
                                <th>Kategori</th>
                                <th>Foto PJ</th>
                                <th>NUP/Ruangan</th>
                                <th class="text-center">Stok</th>
                                <th>Mulai</th>
                                <th>Selesai</th>
                                <th class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($products as $product)
                            <tr>
                                <td>
                                    <strong>{{ $product->nama_barang }}</strong><br>
                                    <small class="text-muted">{{ $product->description ? \Illuminate\Support\Str::limit($product->description, 50) : 'Tanpa deskripsi' }}</small>
                                </td>
                                <td>
                                    {{-- Asumsi kategori memiliki properti nama_kategori atau nama_barang --}}
                                    <span class="badge bg-secondary">{{ $product->category->nama_kategori ?? $product->category->nama_barang ?? '-' }}</span>
                                </td>
                               <td class="text-center">
                                        @if ($product->photo_path)
                                            <a href="{{ Storage::url($product->photo_path) }}" 
                                               {{-- HAPUS data-toggle dan data-target agar JS manual yang mengontrol --}}
                                               data-photo-url="{{ Storage::url($product->photo_path) }}"
                                               data-photo-name="{{ $product->nama_lengkap ?? 'Foto Penanggung Jawab' }}"
                                               class="photo-trigger"> {{-- Tambahkan class untuk target JS --}}
                                                <img src="{{ Storage::url($product->photo_path) }}" alt="Foto PJ" 
                                                     class="img-circle" style="width: 35px; height: 35px; object-fit: cover; border: 1px solid #ddd;">
                                            </a>
                                        @else
                                            <i class="fas fa-user-circle fa-2x text-muted" title="Tidak Ada Foto"></i>
                                        @endif
                                    </td>
                                <td>{{ $product->nup_ruangan ?? '-' }}</td>
                                <td class="text-center">
                                    {{ $product->stok_barang }}
                                    @if($product->stok_barang < 5)
                                        <span class="badge bg-danger ms-1" title="Stok Menipis">↓</span>
                                    @endif
                                </td>
                                <td>
                                    {{ $product->tanggal_mulai ? \Carbon\Carbon::parse($product->tanggal_mulai)->format('d M Y') : '-' }}
                                </td>
                                <td>
                                    {{ $product->tanggal_selesai ? \Carbon\Carbon::parse($product->tanggal_selesai)->format('d M Y') : '-' }}
                                </td>
                                <td text-center align-middle"> 
                                        <div class="btn-group" role="group">
                                            <a href="{{ route('user.products.edit', $product->id) }}" 
                                               class="btn btn-warning text-white d-inline-flex justify-content-center align-items-center me-1" title="Edit" style="width: 35px; height: 35px; padding: 0; border-radius: 1;">> 
                                                <i class="fas fa-edit fa-sm"></i> 
                                            </a>
                                            <form action="{{ route('user.products.destroy', $product->id) }}" 
                                                  method="POST" style="display:inline;" onsubmit="return confirm('Yakin ingin menghapus produk {{ $product->nama_barang }}?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger d-inline-flex justify-content-center align-items-center" style="width: 35px; height: 35px; padding: 0; border-radius: 1;">
                                                    <i class="fas fa-trash fa-sm"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="alert alert-info text-center my-3">
                    <i class="fas fa-info-circle me-1"></i> Belum ada barang yang ditambahkan. Silakan klik "Tambah Barang Baru" untuk memulai inventarisasi.
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
