@extends('layouts.main')

@section('header')
    <h1>{{ isset($category) ? 'Edit Kategori' : 'Tambah Kategori' }}</h1>
@endsection

@section('content')
<div class="row">
    <div class="col">
        <div class="card">
            <div class="card-body">
                <form action="{{ isset($category) ? route('admin.categories.update', $category->id) : route('admin.categories.store') }}" method="POST">
                    @csrf
                    @if (isset($category))
                        @method('PUT')
                    @endif

                    <div class="form-group">
                        <label>Nama Kategori</label>
                        <input type="text" name="nama_barang" class="form-control" value="{{ old('nama_barang', $category->nama_barang ?? '') }}">
                    </div>

                    <button type="submit" class="btn btn-primary">{{ isset($category) ? 'Update' : 'Simpan' }}</button>
                    <a href="{{ route('admin.categories.index') }}" class="btn btn-secondary">Batal</a>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection