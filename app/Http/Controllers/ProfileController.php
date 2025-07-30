<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Product;

class ProfileController extends Controller
{
    /**
     * Tampilkan halaman profil sesuai role.
     */
    public function show()
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();
        $role = $user->role;

        // Data tambahan hanya untuk user
        $alat = $role === 'user'
            ? Product::where('user_id', $user->id)->get()
            : null;

        return view('profile', compact('user', 'alat'));
    }

    /**
     * Tampilkan form edit profil.
     */
    public function edit()
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();
        return view('profile_edit', compact('user'));
    }

    /**
     * Proses update data profil.
     */
    public function update(Request $request)
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        $request->validate([
            'name'  => 'required|string|max:100',
            'email' => 'required|email|unique:users,email,' . $user->id,
        ]);

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
        ]);

        return redirect()->route('profile')->with('success', 'Profil berhasil diperbarui.');
    }
}