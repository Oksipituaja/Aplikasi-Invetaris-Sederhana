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
                {{-- TOMBOL TAMBAH --}}
                <a href="{{ route('admin.products.create') }}" class="btn btn-success me-2">
                    <i class="fas fa-plus"></i> Tambah Produk
                </a>

                {{-- TOMBOL BARU: EXPORT CSV --}}
                <a href="{{ route('admin.products.export.csv', ['category_id' => request('category_id')]) }}" class="btn btn-info me-2" title="Ekspor data yang difilter ke CSV">
                    <i class="fas fa-file-csv"></i> Export CSV
                </a>

                {{-- TOMBOL BARU: CETAK LANGSUNG --}}
                <button onclick="window.print()" class="btn btn-secondary me-2" title="Cetak halaman ini">
                    <i class="fas fa-print"></i> Cetak
                </button>
@endsection

{{-- STYLE BARU KHUSUS CETAK --}}
@section('styles')
<style>
    @media print {
        /* Sembunyikan header, sidebar, footer, dan tombol saat mencetak */
        .main-header, .main-sidebar, .main-footer, .card-header, .breadcrumb, .print-hide {
            display: none !important;
        }
        /* Tampilkan konten dengan margin minimal */
        .content-wrapper {
            padding: 0 !important;
            margin: 0 !important;
        }
        /* Pastikan tabel terlihat baik */
        table {
            width: 100%;
        }
        /* Sembunyikan kolom Aksi saat dicetak */
        .hide-on-print {
            display: none !important;
        }
    }
</style>
@endsection

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card card-outline card-primary">
            <div class="card-header print-hide"> 
                
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
                                <th class="text-center" style="width: 70px;">Foto PJ</th> 
                                <th>Penanggung Jawab (Detail)</th>
                                <th>NUP/Ruangan</th>
                                <th>Periode</th>
                                <th class="text-center hide-on-print" style="width: 100px;">Aksi</th> {{-- Ratakan judul Aksi --}}
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($products as $product)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>
                                        <strong>{{ $product->nama_barang }}</strong><br>
                                        <small class="text-muted">Keterangan: {{ $product->description ? \Illuminate\Support\Str::limit($product->description, 30) : 'Tanpa Keterangan' }}</small>
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
                                    
                                    {{-- KOLOM FOTO --}}
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
                                    
                                    {{-- DETAIL PJ --}}
                                    <td>
                                        <small>{{ $product->nama_lengkap ?? 'Unknown' }}</small><br> 
                                        <small>NIM: {{ $product->nim ?? '-' }}</small><br>
                                        <small>Prodi: {{ $product->prodi ?? '-' }}</small><br>
                                        <small>No.HP: {{ $product->phone_number ?? '-' }}</small>
                                    </td>
                                    
                                    <td>{{ $product->nup_ruangan ?? '-' }}</td>
                                    <td>
                                        <small>Mulai: {{ $product->tanggal_mulai ? \Carbon\Carbon::parse($product->tanggal_mulai)->format('d/m/Y') : '-' }}</small><br>
                                        <small>Selesai: {{ $product->tanggal_selesai ? \Carbon\Carbon::parse($product->tanggal_selesai)->format('d/m/Y') : 'Tidak Ditentukan' }}</small>
                                    </td>
                                    <td class="text-center align-middle hide-on-print"> {{-- Tambahkan class hide-on-print --}}
                                        <div class="btn-group" role="group">
                                            <a href="{{ route('admin.products.edit', $product->id) }}" 
                                                class="btn btn-warning text-white d-inline-flex justify-content-center align-items-center me-1" title="Edit" style="width: 35px; height: 35px; padding: 0; border-radius: 1;">
                                                <i class="fas fa-edit fa-sm"></i> 
                                            </a>
                                            <form action="{{ route('admin.products.destroy', $product->id) }}" 
                                                    method="POST" style="display:inline;" onsubmit="return confirm('Yakin ingin menghapus produk {{ $product->nama_barang }}?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger d-inline-flex justify-content-center align-items-center" title="Hapus" style="width: 35px; height: 35px; padding: 0; border-radius: 1;">
                                                    <i class="fas fa-trash fa-sm"></i>
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
            </div>
        </div>
    </div>
</div>
@endsection

{{-- MODAL DAN SCRIPT (Tetap dipertahankan untuk fungsionalitas popup foto) --}}
<div class="modal fade" id="photoModal" tabindex="-1" role="dialog" aria-labelledby="photoModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="photoModalLabel">Foto Penanggung Jawab</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body text-center">
                <img id="modalPhoto" src="" class="img-fluid rounded" alt="Foto Penanggung Jawab" style="max-height: 80vh; max-width: 100%;">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>

@section('scripts')
{{-- Script Modal --}}
<script>
    $(document).ready(function() {
        $('.photo-trigger').on('click', function(e) {
            e.preventDefault(); 
            
            var photoUrl = $(this).data('photo-url'); 
            var photoName = $(this).data('photo-name'); 
            var modal = $('#photoModal');
            
            modal.find('.modal-title').text('Foto: ' + (photoName || 'Penanggung Jawab'));
            modal.find('#modalPhoto').attr('src', photoUrl);
            modal.modal('show');
        });
    });
</script>
@endsection