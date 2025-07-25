<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Report;
use App\Models\Inventaris;

class UserReportController extends Controller
{
    public function create()
    {
        // Ambil daftar nama barang unik untuk input bebas + filter
        $barangList = Inventaris::select('nama_barang')->distinct()->get();

        return view('user.cek-alat', compact('barangList'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_barang' => 'required|string|max:100',
            'kondisi'     => 'required|in:baik,rusak,perlu perawatan',
            'catatan'     => 'nullable|string|max:255'
        ]);

        Report::create([
            'user_id'     => Auth::id(),
            'nama_barang' => $request->nama_barang,
            'kondisi'     => $request->kondisi,
            'catatan'     => $request->catatan,
        ]);

        return redirect()->route('user.home')->with('success', 'Laporan berhasil dikirim!');
    }
}