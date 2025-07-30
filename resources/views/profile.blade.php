@extends('layouts.app')

@section('title', 'Profil Saya')

@section('content')
<div class="container py-4">
    <div class="card shadow-sm border-0">
        <div class="card-header bg-primary text-white">
            <h5 class="mb-0">
                <i class="fas fa-user-circle me-2"></i>
                Profil Saya ({{ ucfirst(Auth::user()->role) }})
            </h5>
        </div>
        <div class="card-body">
            @php
                $user = Auth::user();
            @endphp

            <div class="row mb-3">
                <label class="col-sm-3 text-muted">Nama Lengkap</label>
                <div class="col-sm-9 fw-semibold">{{ $user->name }}</div>
            </div>
            <div class="row mb-3">
                <label class="col-sm-3 text-muted">Email</label>
                <div class="col-sm-9 fw-semibold">{{ $user->email }}</div>
            </div>
            <div class="row mb-3">
                <label class="col-sm-3 text-muted">Role</label>
                <div class="col-sm-9">
                    <span class="badge bg-info text-white">{{ ucfirst($user->role) }}</span>
                </div>
            </div>

            <div class="text-end mt-4">
                <a href="{{ route('profile.edit') }}" class="btn btn-outline-primary">
                    <i class="fas fa-edit me-1"></i> Ubah Profil
                </a>
            </div>
        </div>
    </div>
</div>
@endsection