<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log; // Tambahan untuk logging error

class UserProductController extends Controller
{
    public function index()
    {
        try {
            // Mengambil produk milik user
            $products = Auth::user()->products()->latest()->get();
            
            // Mengembalikan view. Pastikan file resources/views/user/products/index.blade.php ADA.
            return view('user.products.index', compact('products'));
        } catch (\Exception $e) {
            // Jika error, akan tampil pesan ini daripada Error 500 polos
            return response()->json(['error' => 'Gagal memuat halaman index: ' . $e->getMessage()], 500);
        }
    }

    public function create()
    {
        try {
            // Mengambil kategori untuk dropdown
            $categories = Category::all();
            
            // Mengembalikan view. Pastikan file resources/views/user/products/create.blade.php ADA.
            return view('user.products.create', compact('categories'));
        } catch (\Exception $e) {
            return response()->json(['error' => 'Gagal memuat halaman create: ' . $e->getMessage()], 500);
        }
    }

    // ... (Metode store, edit, update, destroy biarkan dulu seperti sebelumnya) ...
    
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
        Product::create($validatedData);

        return redirect()->route('user.products.index')->with('success', 'Produk berhasil ditambahkan!');
    }

    public function edit(Product $product)
    {
        if ($product->user_id !== Auth::id()) abort(403);
        $categories = Category::all();
        return view('user.products.edit', compact('product', 'categories'));
    }

    public function update(Request $request, Product $product)
    {
        if ($product->user_id !== Auth::id()) abort(403);
        // (Validasi sama seperti store)
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
        return redirect()->route('user.products.index')->with('success', 'Update berhasil');
    }

    public function destroy(Product $product)
    {
        if ($product->user_id !== Auth::id()) abort(403);
        $product->delete();
        return redirect()->route('user.products.index')->with('success', 'Hapus berhasil');
    }
}
