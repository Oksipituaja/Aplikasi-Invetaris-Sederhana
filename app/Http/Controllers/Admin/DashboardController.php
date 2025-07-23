<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Support\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        // Produk mendekati tanggal selesai dalam 7 hari
        $produkKadaluarsa = Product::whereDate('tanggal_selesai', '>=', now())
            ->whereDate('tanggal_selesai', '<=', now()->addDays(1))
            ->orderBy('tanggal_selesai')
            ->get();

        // Produk terbaru
        $produkTerbaru = Product::latest()->with('category')->take(5)->get();

        // Distribusi kategori
        $kategoriData = Category::withCount('products')->get()
            ->pluck('products_count', 'nama_barang')->toArray();

        return view('admin.dashboard', [
            'produkCount'       => Product::count(),
            'kategoriCount'     => Category::count(),
            'totalStok'         => Product::sum('stok_barang'),
            'stokRendah'        => Product::where('stok_barang', '<', 5)->count(),
            'produkKadaluarsa'  => $produkKadaluarsa,
            'produkTerbaru'     => $produkTerbaru,
            'kategoriData'      => $kategoriData,
        ]);
    }
}