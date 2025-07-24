<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $jam = Carbon::now('Asia/Jakarta')->format('H');

        if ($jam >= 5 && $jam < 12) {
            $greeting = 'Selamat Pagi 👋';
        } elseif ($jam >= 12 && $jam < 17) {
            $greeting = 'Selamat Siang 👋';
        } elseif ($jam >= 17 && $jam < 21) {
            $greeting = 'Selamat Sore 👋';
        } else {
            $greeting = 'Selamat Malam 👋';
        }

        $produkKadaluarsa = Product::whereDate('tanggal_selesai', '>=', now())
            ->whereDate('tanggal_selesai', '<=', now()->addDays(1))
            ->orderBy('tanggal_selesai')
            ->get();

        $produkTerbaru = Product::latest()->with('category')->take(5)->get();

        $kategoriData = Category::withCount('products')->get()
            ->pluck('products_count', 'nama_barang')->toArray();

        return view('admin.dashboard', [
            'user'              => $user,
            'produkCount'       => Product::count(),
            'kategoriCount'     => Category::count(),
            'totalStok'         => Product::sum('stok_barang'),
            'stokRendah'        => Product::where('stok_barang', '<', 5)->count(),
            'produkKadaluarsa'  => $produkKadaluarsa,
            'produkTerbaru'     => $produkTerbaru,
            'kategoriData'      => $kategoriData,
            'greeting'          => $greeting,
        ]);
    }
}