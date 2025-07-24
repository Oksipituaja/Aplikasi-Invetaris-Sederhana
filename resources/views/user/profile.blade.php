@extends('layouts.user')
@section('title', 'Profil & Kondisi Alat')
@section('content')
<div class="row">
  <div class="col-md-6">
    <div class="card">
      <div class="card-header bg-primary text-white">Profil</div>
      <div class="card-body">
        <p><strong>Nama:</strong> {{ $user->name }}</p>
        <p><strong>Email:</strong> {{ $user->email }}</p>
        <p><strong>Role:</strong> {{ ucfirst($user->role) }}</p>
      </div>
    </div>
  </div>

  <div class="col-md-6">
    <div class="card">
      <div class="card-header bg-success text-white">Kondisi Alat</div>
      <div class="card-body">
        <ul class="list-group">
          @foreach($alat as $a)
            <li class="list-group-item d-flex justify-content-between">
              {{ $a->nama_barang }}
              <span class="badge bg-{{ $a->kondisi === 'baik' ? 'success' : ($a->kondisi === 'rusak' ? 'danger' : 'warning') }}">
                {{ ucfirst($a->kondisi) }}
              </span>
            </li>
          @endforeach
        </ul>
      </div>
    </div>
  </div>
</div>
@endsection