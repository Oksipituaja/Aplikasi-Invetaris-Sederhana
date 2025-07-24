<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $query = User::query();

        if ($request->filled('cari')) {
            $query->where('name', 'like', '%' . $request->input('cari') . '%');
        }

        $users = $query->get();

        return view('admin.users.index', compact('users'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'     => 'required|string|max:100',
            'email'    => 'required|email|unique:users,email',
            'password' => 'required|min:8',
            'role'     => 'required|in:admin,user',
        ]);

        $validated['password'] = Hash::make($validated['password']);
        User::create($validated);

        return redirect()->route('admin.users.index')->with('success', 'Pengguna berhasil ditambahkan!');
    }

    public function edit($id)
    {
        $user = User::findOrFail($id);
        return view('admin.users.edit', compact('user'));
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'name'  => 'required|string|max:100',
            'email' => 'required|email|unique:users,email,' . $id,
            'role'  => 'required|in:admin,user',
        ]);

        /** @var \App\Models\User $user */
        $user = User::findOrFail($id);
        $user->update($validated);

        // Logout otomatis jika user sedang login dan role-nya berubah jadi 'user'
        if (Auth::check()) {
            $currentUser = Auth::user();
            if ($currentUser && $currentUser->id === $user->id && $user->role === 'user') {
                Auth::logout();
                return redirect()->route('login')->with('message', 'Role kamu telah diubah. Silakan login ulang sebagai user.');
            }
        }

        return redirect()->route('admin.users.index')->with('success', 'Pengguna berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return redirect()->route('admin.users.index')->with('success', 'Pengguna berhasil dihapus!');
    }
}