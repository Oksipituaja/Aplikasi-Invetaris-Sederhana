@extends('layouts.main')

@section('header')
    <h1>Kategori</h1>
@endsection

@section('content')
@if (session('success'))
                        <div class="alert alert-success alert-dismissible fade show" id="success-alert">
                            {{ session('success') }}
                            <button class="close" data-dismiss="alert">&times;</button>
                        </div>

                        <script>
                            setTimeout(function() {
                                let alertBox = document.getElementById('success-alert');
                                if (alertBox) {
                                    alertBox.classList.remove('show');
                                    alertBox.classList.add('fade');
                                    alertBox.style.opacity = '0';
                                    setTimeout(() => alertBox.remove(), 500);
                                }
                            }, 5000)
                        </script>
                    @endif

<div class="card">
    <div class="card-body">
        <a href="{{ route('admin.categories.create') }}" class="btn btn-primary mb-3">Tambah Kategori</a>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama Kategori</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($categories as $category)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $category->nama_barang }}</td>
                        <td>
                            <a href="{{ route('admin.categories.edit', $category->id) }}" class="btn btn-sm btn-warning">Edit</a>
                            <form action="{{ route('admin.categories.destroy', $category->id) }}" method="POST" style="display:inline;">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Yakin?')">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection