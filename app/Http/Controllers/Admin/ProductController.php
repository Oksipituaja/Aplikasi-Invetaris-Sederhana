<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use App\Models\User; // Tambahkan
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage; // Tambahkan untuk file handling
use Carbon\Carbon;

class ProductController extends Controller
{
    // Aturan Validasi untuk Store dan Update
    protected function validationRules()
    {
        return [
            'user_id'       => 'nullable|exists:users,id',
            'nama_lengkap'  => 'required|string|max:255',
            'nim'           => 'nullable|string|max:20', // Sesuaikan max length jika perlu
            'prodi'         => 'required|string|max:100', // Sesuaikan max length jika perlu
            'phone_number'  => 'nullable|string|max:15', // Tambahkan field ini
            'photo'         => 'nullable|image|max:2048', // Tambahkan field ini
            
            'nama_barang'   => 'required|string|max:255',
            'description'   => 'nullable|string',
            'nup_ruangan'   => 'required|string|max:255',
            'tanggal_mulai' => 'required|date',
            'tanggal_selesai' => 'nullable|date|after_or_equal:tanggal_mulai',
            'category_id'   => 'required|exists:categories,id',
            'stok_barang'   => 'required|integer|min:0',
        ];
    }

    public function index(Request $request)
    {
        $categories = Category::all();
        $productsQuery = Product::with('category');

        if ($request->filled('category_id')) {
            $productsQuery->where('category_id', $request->category_id);
        }

        $products = $productsQuery->latest()->get(); // Tambahkan latest() untuk urutan
        return view('admin.products.index', compact('products', 'categories'));
    }

    public function create()
    {
        $categories = Category::all();
        $users = User::where('is_active', true)->orderBy('name')->get(); // Ambil data user
        return view('admin.products.form', compact('categories', 'users'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate($this->validationRules());

        // 1. Handle File Upload (Photo)
        if ($request->hasFile('photo')) {
            $path = $request->file('photo')->store('products_photos', 'public');
            $validated['photo_path'] = $path;
        }

        // Tidak perlu lagi Carbon::parse, biarkan Laravel/Eloquent menangani format date.
        // Cukup pastikan kolom tanggal di $validated ada, yang sudah dijamin dari Request

        Product::create($validated);

        return redirect()->route('admin.products.index')->with('success', 'Produk berhasil ditambahkan');
    }

    public function edit(Product $product)
    {
        $categories = Category::all();
        $users = User::where('is_active', true)->orderBy('name')->get(); // Ambil data user
        return view('admin.products.form', compact('product', 'categories', 'users'));
    }

    public function update(Request $request, Product $product)
    {
        // Gunakan validationRules() yang sama
        $validated = $request->validate($this->validationRules());
        
        // 1. Handle File Upload (Photo)
        if ($request->hasFile('photo')) {
            // Hapus foto lama jika ada
            if ($product->photo_path) {
                Storage::disk('public')->delete($product->photo_path);
            }
            $path = $request->file('photo')->store('products_photos', 'public');
            $validated['photo_path'] = $path;
        } else {
            // Jika tidak ada foto baru diupload, pastikan kolom photo_path tidak hilang
            // Opsi: Anda mungkin perlu input hidden untuk menghapus foto secara eksplisit, 
            // tapi kita asumsikan jika tidak ada file baru, foto lama dipertahankan.
            // Tidak perlu mengubah $validated['photo_path'] di sini.
        }

        // Tidak perlu lagi Carbon::parse

        $product->update($validated);

        return redirect()->route('admin.products.index')->with('success', 'Barang berhasil diperbarui');
    }

    public function destroy(Product $product)
    {
        // Hapus file foto terkait jika ada sebelum menghapus record
        if ($product->photo_path) {
            Storage::disk('public')->delete($product->photo_path);
        }
        
        $product->delete();
        return redirect()->route('admin.products.index')->with('success', 'Barang berhasil dihapus');
    }
}