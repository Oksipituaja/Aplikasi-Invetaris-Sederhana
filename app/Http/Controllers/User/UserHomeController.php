<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class UserHomeController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $hour = now()->format('H');
        $greeting = $hour < 12 ? 'Selamat Pagi 👋' : ($hour < 17 ? 'Selamat Siang 👋' : 'Selamat Malam 🌙');

        return view('user.home', compact('user', 'greeting'));
    }
}