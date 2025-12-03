@extends('layouts.main')

@section('header')
    <div class="row mb-2 align-items-center">
        <div class="col">
            <div class="alert alert-primary shadow-sm" id="greeting-alert">
                {{ $greeting }} <strong>{{ $user->name }}</strong>, selamat datang kembali di dashboard inventaris! Kamu login
                sebagai <span class="badge bg-info text-white">{{ $user->role }}</span>.
            </div>

            <h1 class="mb-0">Dashboard</h1>
        </div>
    </div>
@endsection

@section('content')
    {{-- Ringkasan --}}
    <div class="row">
        @foreach ([['Total Barang', $produkCount, 'fas fa-cube', 'info'], ['Total Kategori', $kategoriCount, 'fas fa-tags', 'success'], ['Total Stok', $totalStok, 'fas fa-boxes', 'warning'], ['Stok Rendah (< 5)', $stokRendah, 'fas fa-exclamation-triangle', 'danger']] as [$label, $jumlah, $icon, $bg])
            <div class="col-md-6 col-lg-3 mb-4">
                <div class="small-box bg-{{ $bg }} shadow-sm">
                    <div class="inner">
                        <h3>{{ $jumlah }}</h3>
                        <p>{{ $label }}</p>
                    </div>
                    <div class="icon">
                        <i class="{{ $icon }}"></i>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    {{-- Notifikasi --}}
    @if ($produkKadaluarsa->count())
        <div class="alert alert-warning shadow-sm">
            <strong><i class="fas fa-clock mr-1"></i>Perhatian:</strong> Ada <b>{{ $produkKadaluarsa->count() }}</b> produk
            yang akan melewati tanggal selesai dalam <b>1 hari</b>.
            <ul class="mt-2 mb-0">
                @foreach ($produkKadaluarsa as $item)
                    <li>{{ $item->nama_barang }} <span class="badge badge-light">{{ $item->tanggal_selesai }}</span></li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- Produk Terbaru --}}
    <div class="card shadow-sm">
        <div class="card-header bg-primary text-white">
            <div class="row w-100 align-items-center">
                <div class="col">
                    <h3 class="card-title mb-0">Produk Terbaru</h3>
                </div>
                <div class="col-auto">
                    <a href="{{ route('admin.products.index') }}" class="btn btn-sm btn-light text-primary">Lihat Semua</a>
                </div>
            </div>
        </div>
        <div class="card-body p-0">
            <table class="table table-striped table-hover mb-0">
                <thead class="thead-light">
                    <tr>
                        <th>Nama Barang</th>
                        <th>Kategori</th>
                        <th>Stok</th>
                        <th>Tanggal Mulai</th>
                        <th>Tanggal Selesai</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($produkTerbaru as $produk)
                        <tr>
                            <td>{{ $produk->nama_barang }}</td>
                            <td>{{ $produk->category->nama_barang ?? '-' }}</td>
                            <td>
                                <span class="badge badge-{{ $produk->stok_barang < 5 ? 'danger' : 'secondary' }}">
                                    {{ $produk->stok_barang }}
                                </span>
                            </td>
                            <td>{{ $produk->tanggal_mulai }}</td>
                            <td>{{ $produk->tanggal_selesai }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center text-muted">Belum ada data produk.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- Grafik Kategori --}}
    <div class="row mt-4">

        {{-- Bar Chart --}}
        <div class="col-12 mb-4">
            <div class="card shadow-sm h-60">
                <div class="card-header ">
                    <h3 class="card-title">Total Stok per Kategori</h3>
                </div>
                <div class="card-body">
                    <canvas id="kategoriBarChart" height="40" width="100%"></canvas>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        window.addEventListener('load', function() {
            const labels = @json(array_keys($kategoriData));
            const values = @json(array_values($kategoriData));

            // Bar Chart
            new Chart(document.getElementById('kategoriBarChart').getContext('2d'), {
                type: 'bar',
                data: {
                    labels: labels,
                    datasets: [{
                        label: 'Jumlah Barang',
                        data: values,
                        backgroundColor: '#007bff'
                    }]
                },
                options: {
                    scales: {
                        y: {
                            beginAtZero: true,
                            max: 50, // 🎯 Tetapkan angka tertinggi sumbu Y
                            ticks: {
                                stepSize: null // opsional: ubah interval sumbu
                            }
                        }
                    },
                    plugins: {
                        legend: {
                            display: false
                        }
                    }
                }
            });
        });
    </script>
    <script>
    window.addEventListener('load', function () {
        const greetingAlert = document.getElementById('greeting-alert');
        if (greetingAlert) {
            setTimeout(() => {
                greetingAlert.classList.add('fade');
                greetingAlert.classList.remove('show');
                greetingAlert.style.transition = 'opacity 0.5s ease';
                greetingAlert.style.opacity = '0';
                setTimeout(() => greetingAlert.remove(), 500); // hapus dari DOM setelah fade
            }, 5000); // 5 detik
        }
    });
</script>
@endsection
