@extends('layouts.main')

@section('content')
<h3>Edit Pengguna</h3>

<form method="POST" action="{{ route('admin.users.update', $user->id) }}">
    @csrf @method('PUT')

    <div class="form-group">
        <label>Nama</label>
        <input type="text" name="name" class="form-control" value="{{ $user->name }}" required>
    </div>

    <div class="form-group">
        <label>Email</label>
        <input type="email" name="email" class="form-control" value="{{ $user->email }}" required>
    </div>

    <div class="form-group">
        <label>Role</label>
        <select name="role" class="form-control" required>
            <option value="admin" {{ $user->role === 'admin' ? 'selected' : '' }}>Admin</option>
            <option value="user" {{ $user->role === 'user' ? 'selected' : '' }}>User</option>
        </select>
    </div>

    <button class="btn btn-success mt-3">Update</button>
    <a href="{{ route('admin.users.index') }}" class="btn btn-secondary mt-3">Kembali</a>
</form>
@endsection