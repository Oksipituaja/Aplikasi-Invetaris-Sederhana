@extends('layouts.main')

@section('content')
    <h3 class="mb-3">Manajemen Pengguna</h3>

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

    <!-- Tombol Tambah -->
    <button class="btn btn-primary mb-3" data-toggle="modal" data-target="#modalTambahUser">
        <i class="fas fa-user-plus"></i> Tambah Pengguna
    </button>

    <!-- Form Pencarian -->
    <form method="GET" class="mb-3">
        <input type="text" name="cari" class="form-control" placeholder="Cari nama..." value="{{ request('cari') }}">
    </form>

    <!-- Tabel -->
    <table class="table table-bordered table-striped">
        <thead class="thead-light">
            <tr>
                <th>Nama</th>
                <th>Email</th>
                <th>Role</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($users as $user)
                <tr>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <td>
                        <span class="badge @if ($user->role === 'admin') bg-danger @else bg-info @endif text-white">
                            {{ ucfirst($user->role) }}
                        </span>
                    </td>
                    <td>
                        <a href="{{ route('admin.users.edit', $user->id) }}" class="btn btn-sm btn-warning">Edit</a>
                        <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST"
                            style="display:inline-block" onsubmit="return confirm('Yakin ingin menghapus pengguna ini?')">
                            @csrf @method('DELETE')
                            <button class="btn btn-sm btn-danger">Hapus</button>
                        </form>
                    </td>

                </tr>
            @empty
                <tr>
                    <td colspan="3" class="text-center text-muted">Belum ada pengguna.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <!-- Modal -->
    <div class="modal fade" id="modalTambahUser" tabindex="-1">
        <div class="modal-dialog">
            <form method="POST" action="{{ route('admin.users.store') }}">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Tambah Pengguna</h5>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body">
                        <input type="text" name="name" class="form-control mb-2" placeholder="Nama" required>
                        <input type="email" name="email" class="form-control mb-2" placeholder="Email" required>
                        <input type="password" name="password" class="form-control mb-2" placeholder="Password" required>
                        <select name="role" class="form-control mb-2" required>
                            <option value="admin">Admin</option>
                            <option value="user">User</option>
                        </select>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Simpan</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
