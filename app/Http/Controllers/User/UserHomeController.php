<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class UserHomeController extends Controller
{
    public function index()
    {
        // Pengecekan user aman
        $user = Auth::user();
        
        // Hapus logika waktu (now()) yang berpotensi menyebabkan error library
        // Gunakan string statis sederhana
        $greeting = 'Selamat Datang Kembali';

        // Pastikan view dipanggil dengan variabel yang dibutuhkan
        return view('user.home', compact('user', 'greeting'));
    }
}
