@extends('layouts.app') 

@section('title', 'Daftar Barang Saya')

@section('styles')
<style>
    @media print {
        /* Sembunyikan semua elemen navigasi dan tombol saat mencetak */
        .navbar, .print-hide, .btn, .modal-backdrop {
            display: none !important;
        }
        /* Tampilkan konten dengan margin minimal */
        .container {
            margin: 0 !important;
            padding: 0 !important;
            max-width: none !important;
        }
        /* Sembunyikan kolom Aksi saat dicetak */
        .hide-on-print {
            display: none !important;
        }
    }
</style>
@endsection

@section('content')
<div class="container py-4">

    {{-- TAMBAHKAN KELAS print-hide UNTUK TOMBOL DAN JUDUL --}}
    <div class="d-flex justify-content-between align-items-center mb-3 print-hide"> 
        <h4><i class="fas fa-clipboard-list me-2"></i> Daftar Barang Inventaris Saya</h4>
        <div>
            <a href="{{ route('user.products.create') }}" class="btn btn-success me-2">
                <i class="fas fa-plus"></i> Tambah Barang Baru
            </a>
            
            {{-- TOMBOL BARU: EXPORT CSV --}}
            {{-- <a href="{{ route('user.products.export.csv') }}" class="btn btn-info me-2" title="Ekspor data ke CSV">
                <i class="fas fa-file-csv"></i> Export CSV
            </a> --}}

            {{-- TOMBOL BARU: CETAK LANGSUNG --}}
            {{-- <button onclick="window.print()" class="btn btn-secondary" title="Cetak halaman ini">
                <i class="fas fa-print"></i> Cetak
            </button> --}}
        </div>
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
                                <th class="text-center">Foto PJ</th>
                                <th>Penanggung Jawab (Detail)</th>
                                <th>NUP/Ruangan</th>
                                <th class="text-center">Stok</th>
                                <th>Mulai</th>
                                <th>Selesai</th>
                                <th class="text-center hide-on-print">Aksi</th> {{-- Tambahkan class hide-on-print --}}
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
                                    <span class="badge bg-secondary">{{ $product->category->nama_kategori ?? $product->category->nama_barang ?? '-' }}</span>
                                </td>
                               <td class="text-center">
                                    @if ($product->photo_path)
                                        <a href="{{ Storage::url($product->photo_path) }}" 
                                            data-photo-url="{{ Storage::url($product->photo_path) }}"
                                            data-photo-name="{{ $product->nama_lengkap ?? 'Foto Penanggung Jawab' }}"
                                            class="photo-trigger"> 
                                            <img src="{{ Storage::url($product->photo_path) }}" alt="Foto PJ" 
                                                class="img-circle" style="width: 35px; height: 35px; object-fit: cover; border: 1px solid #ddd;">
                                        </a>
                                    @else
                                        <i class="fas fa-user-circle fa-2x text-muted" title="Tidak Ada Foto"></i>
                                    @endif
                                </td>
                                <td>
                                    <small>{{ $product->nama_lengkap ?? 'Unknown' }}</small><br> 
                                    <small>NIM: {{ $product->nim ?? '-' }}</small><br>
                                    <small>Prodi: {{ $product->prodi ?? '-' }}</small>
                                    <small>No.HP: {{ $product->phone_number ?? '-' }}</small>
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
                                <td class="text-center align-middle hide-on-print"> {{-- Tambahkan class hide-on-print --}}
                                        <div class="btn-group" role="group">
                                            <a href="{{ route('user.products.edit', $product->id) }}" 
                                                class="btn btn-warning text-white d-inline-flex justify-content-center align-items-center me-1" title="Edit" style="width: 35px; height: 35px; padding: 0; border-radius: 1;">
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

{{-- MODAL UNTUK FOTO (Tetap dipertahankan) --}}
<div class="modal fade" id="photoModal" tabindex="-1" aria-labelledby="photoModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="photoModalLabel">Foto Penanggung Jawab</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-center">
                <img id="modalPhoto" src="" class="img-fluid rounded" alt="Foto Penanggung Jawab" style="max-height: 80vh; max-width: 100%;">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>

@section('scripts')
{{-- Script Modal untuk Bootstrap 5 --}}
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const photoModal = new bootstrap.Modal(document.getElementById('photoModal'));
        
        document.querySelectorAll('.photo-trigger').forEach(trigger => {
            trigger.addEventListener('click', function (e) {
                e.preventDefault(); 
                
                const photoUrl = this.getAttribute('data-photo-url');
                const photoName = this.getAttribute('data-photo-name');
                
                document.getElementById('photoModalLabel').textContent = 'Foto: ' + (photoName || 'Penanggung Jawab');
                document.getElementById('modalPhoto').setAttribute('src', photoUrl);
                
                photoModal.show();
            });
        });
    });
</script>
@endsection