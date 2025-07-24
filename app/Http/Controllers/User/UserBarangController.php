<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\Inventaris;

class UserBarangController extends Controller
{
    public function index()
    {
        $barang = Inventaris::orderBy('nama_barang')->get();
        return view('user.barang.index', compact('barang'));
    }
}