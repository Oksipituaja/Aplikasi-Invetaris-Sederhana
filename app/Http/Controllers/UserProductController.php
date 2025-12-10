<?php

// Pastikan namespace ini sesuai dengan lokasi file Anda, jika berada di subfolder User, maka:
namespace App\Http\Controllers\User; 

use App\Http\Controllers\Controller;
use App\Models\Category; // Pastikan Anda menggunakan Model Category
use App\Models\Product;  // Pastikan Anda menggunakan Model Product
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserProductController extends Controller
{
    public function index()
    {
        $products = Auth::user()->products()->latest()->get();
        return view('user.products.index', compact('products'));
    }

    // [FIX 1: Kirim data categories ke view create]
    public function create()
    {
        $categories = Category::all();
        return view('user.products.create', compact('categories'));
    }

    // [FIX 2: Implementasi store dengan validasi dan user_id]
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'nama_lengkap' => 'required|string|max:255',
            'nim' => 'required|string|max:20',
            'prodi' => 'required|string|max:100',
            'nama_barang' => 'required|string|max:255',
            'description' => 'nullable|string',
            'nup_ruangan' => 'nullable|string|max:50',
            'tanggal_mulai' => 'nullable|date',
            'tanggal_selesai' => 'nullable|date|after_or_equal:tanggal_mulai',
            'stok_barang' => 'required|integer|min:1',
            'category_id' => 'required|exists:categories,id',
        ]);
        
        $validatedData['user_id'] = Auth::id();
        
        // Simpan data
        Product::create($validatedData);

        return redirect()->route('user.products.index')->with('success', 'Produk berhasil ditambahkan!');
    }

    // [FIX 3: Kirim data categories ke view edit dan otorisasi]
    public function edit(Product $product)
    {
        // Otorisasi: Hanya user pemilik yang bisa edit
        if ($product->user_id !== Auth::id()) {
            return redirect()->route('user.products.index')->with('error', 'Anda tidak diizinkan mengedit produk ini.');
        }

        $categories = Category::all();
        return view('user.products.edit', compact('product', 'categories'));
    }

    // [FIX 4: Implementasi update dengan validasi dan otorisasi]
    public function update(Request $request, Product $product)
    {
        // Otorisasi: Hanya user pemilik yang bisa update
        if ($product->user_id !== Auth::id()) {
            return redirect()->route('user.products.index')->with('error', 'Anda tidak diizinkan mengubah produk ini.');
        }
        
        $validatedData = $request->validate([
            'nama_lengkap' => 'required|string|max:255',
            'nim' => 'required|string|max:20',
            'prodi' => 'required|string|max:100',
            'nama_barang' => 'required|string|max:255',
            'description' => 'nullable|string',
            'nup_ruangan' => 'nullable|string|max:50',
            'tanggal_mulai' => 'nullable|date',
            'tanggal_selesai' => 'nullable|date|after_or_equal:tanggal_mulai',
            'stok_barang' => 'required|integer|min:1',
            'category_id' => 'required|exists:categories,id',
        ]);

        $product->update($validatedData);

        return redirect()->route('user.products.index')->with('success', 'Produk berhasil diperbarui!');
    }

    // Metode destroy sudah berfungsi, hanya memastikan otorisasi
    public function destroy(Product $product)
    {
        if ($product->user_id !== Auth::id()) {
            return redirect()->route('user.products.index')->with('error', 'Anda tidak diizinkan menghapus produk ini.');
        }
        
        $product->delete();
        return redirect()->route('user.products.index')->with('success', 'Produk berhasil dihapus!');
    }
}