@extends('layouts.user')
@section('title', 'Laporan Kondisi Barang')
@section('content')
<div class="card">
  <div class="card-body">
    <form method="POST" action="{{ route('user.report.store') }}">
      @csrf
      <div class="mb-3">
        <label>Nama Barang</label>
        <input type="text" name="nama_barang" list="daftar-barang" class="form-control" required>
        <datalist id="daftar-barang">
          @foreach($barangList as $b)
            <option value="{{ $b->nama_barang }}">
          @endforeach
        </datalist>
      </div>
      <div class="mb-3">
        <label>Kondisi</label>
        <select name="kondisi" class="form-control" required>
          <option value="baik">Baik</option>
          <option value="rusak">Rusak</option>
          <option value="perlu perawatan">Perlu Perawatan</option>
        </select>
      </div>
      <div class="mb-3">
        <label>Catatan</label>
        <textarea name="catatan" class="form-control"></textarea>
      </div>
      <button type="submit" class="btn btn-primary">Kirim Laporan</button>
    </form>
  </div>
</div>
@endsection

