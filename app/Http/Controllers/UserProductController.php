<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserProductController extends Controller
{
    public function index()
    {
        $products = Auth::user()->products()->latest()->get();
        return view('user.products.index', compact('products'));
    }

    public function create()
    {
        // FIX: Mengirimkan data categories
        $categories = Category::all();
        return view('user.products.create', compact('categories'));
    }

    public function store(Request $request)
    {
        // 1. Validasi Data
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
        
        // 2. Tambahkan user_id
        $validatedData['user_id'] = Auth::id();
        
        // 3. Simpan data
        Product::create($validatedData);

        return redirect()->route('user.products.index')->with('success', 'Produk berhasil ditambahkan!');
    }

    public function edit(Product $product)
    {
        // Otorisasi: Pastikan user hanya bisa edit produknya sendiri
        if ($product->user_id !== Auth::id()) {
            return redirect()->route('user.products.index')->with('error', 'Anda tidak diizinkan mengedit produk ini.');
        }

        // FIX: Mengirimkan data categories
        $categories = Category::all();
        return view('user.products.edit', compact('product', 'categories'));
    }

    public function update(Request $request, Product $product)
    {
        // Otorisasi: Pastikan user hanya bisa update produknya sendiri
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

    public function destroy(Product $product)
    {
        if ($product->user_id !== Auth::id()) {
            return redirect()->route('user.products.index')->with('error', 'Anda tidak diizinkan menghapus produk ini.');
        }
        
        $product->delete();
        return redirect()->route('user.products.index')->with('success', 'Produk berhasil dihapus!');
    }
}
