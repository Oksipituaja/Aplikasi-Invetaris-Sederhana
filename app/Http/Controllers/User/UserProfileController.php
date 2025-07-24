<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\Inventaris;

class UserProfileController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // Menampilkan barang berdasarkan lokasi atau unit kerja user
        $alat = Inventaris::where('lokasi', 'LIKE', '%' . $user->name . '%')->get();

        return view('user.profile', compact('user', 'alat'));
    }
}