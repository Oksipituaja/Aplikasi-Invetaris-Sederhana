<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage; // Tambahkan untuk file handling

class UserProductController extends Controller
{
    // Aturan Validasi untuk Store dan Update User
    protected function validationRules($isUpdate = false)
    {
        return [
            'nama_lengkap' => 'required|string|max:255',
            'nim' => 'required|string|max:20',
            'prodi' => 'required|string|max:100',
            'phone_number' => 'required|string|max:15', // Tambahkan field ini
            // Jika update, foto bisa nullable. Jika store, kita tetap buat nullable.
            'photo' => 'nullable|image|max:2048', 
            
            'nama_barang' => 'required|string|max:255',
            'description' => 'nullable|string',
            'nup_ruangan' => 'nullable|string|max:50',
            'tanggal_mulai' => 'nullable|date',
            'tanggal_selesai' => 'nullable|date|after_or_equal:tanggal_mulai',
            'stok_barang' => 'required|integer|min:1',
            'category_id' => 'required|exists:categories,id',
        ];
    }
    
    public function index()
    {
        // Mengambil produk milik user yang sedang login
        $products = Auth::user()->products()->latest()->get();
        return view('user.products.index', compact('products'));
    }

    public function create()
    {
        // Mengambil kategori untuk dropdown
        $categories = Category::all();
        return view('user.products.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate($this->validationRules());
        
        // 1. Handle File Upload (Photo)
        if ($request->hasFile('photo')) {
            $path = $request->file('photo')->store('products_photos', 'public');
            $validatedData['photo_path'] = $path; // Simpan path ke database
        }

        $validatedData['user_id'] = Auth::id(); // Otomatis set user yang login
        Product::create($validatedData);

        return redirect()->route('user.products.index')->with('success', 'Produk berhasil ditambahkan!');
    }

    public function edit(Product $product)
    {
        // Autorisasi: Pastikan produk milik user yang sedang login
        if ($product->user_id !== Auth::id()) abort(403, 'Akses Ditolak');
        
        $categories = Category::all();
        return view('user.products.edit', compact('product', 'categories'));
    }

    public function update(Request $request, Product $product)
    {
        // Autorisasi
        if ($product->user_id !== Auth::id()) abort(403, 'Akses Ditolak');
        
        $validatedData = $request->validate($this->validationRules(true));
        
        // 1. Handle File Upload (Photo)
        if ($request->hasFile('photo')) {
            // Hapus foto lama jika ada
            if ($product->photo_path) {
                Storage::disk('public')->delete($product->photo_path);
            }
            $path = $request->file('photo')->store('products_photos', 'public');
            $validatedData['photo_path'] = $path; // Simpan path baru
        }
        
        $product->update($validatedData);
        
        return redirect()->route('user.products.index')->with('success', 'Update berhasil');
    }

    public function destroy(Product $product)
    {
        // Autorisasi
        if ($product->user_id !== Auth::id()) abort(403, 'Akses Ditolak');
        
        // Hapus file foto terkait jika ada
        if ($product->photo_path) {
            Storage::disk('public')->delete($product->photo_path);
        }
        
        $product->delete();
        
        return redirect()->route('user.products.index')->with('success', 'Hapus berhasil');
    }
}