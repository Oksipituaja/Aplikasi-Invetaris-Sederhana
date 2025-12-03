<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Carbon\Carbon;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $categories = Category::all();
        $productsQuery = Product::with('category');

        if ($request->filled('category_id')) {
            $productsQuery->where('category_id', $request->category_id);
        }

        $products = $productsQuery->get();
        return view('admin.products.index', compact('products', 'categories'));
    }

    public function create()
    {
        $categories = Category::all();
        return view('admin.products.form', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_lengkap'    => 'required|string|max:255',
            'nim'             => 'required|string|max:255',
            'prodi'           => 'required|string|max:255',
            'nama_barang'     => 'required|string|max:255',
            'description'     => 'nullable|string',
            'nup_ruangan'     => 'required|string|max:255',
            'tanggal_mulai'   => 'required|date',
            'tanggal_selesai' => 'nullable|date|after_or_equal:tanggal_mulai',
            'category_id'     => 'required|exists:categories,id',
            'stok_barang'     => 'required|integer|min:0',
        ]);

        $data = $request->only([
            'nama_lengkap','nim','prodi','nama_barang','description',
            'nup_ruangan','stok_barang','category_id'
        ]);

        // Simpan tanggal dalam format YYYY-MM-DD
        $data['tanggal_mulai'] = Carbon::parse($request->tanggal_mulai)->format('Y-m-d');
        $data['tanggal_selesai'] = $request->tanggal_selesai
            ? Carbon::parse($request->tanggal_selesai)->format('Y-m-d')
            : null;

        Product::create($data);

        return redirect()->route('admin.products.index')->with('success', 'Produk berhasil ditambahkan');
    }

    public function edit(Product $product)
    {
        $categories = Category::all();
        return view('admin.products.form', compact('product', 'categories'));
    }

    public function update(Request $request, Product $product)
    {
        $request->validate([
            'nama_lengkap'    => 'required|string|max:255',
            'nim'             => 'required|string|max:255',
            'prodi'           => 'required|string|max:255',
            'nama_barang'     => 'required|string|max:255',
            'description'     => 'nullable|string',
            'nup_ruangan'     => 'required|string|max:255',
            'tanggal_mulai'   => 'required|date',
            'tanggal_selesai' => 'nullable|date|after_or_equal:tanggal_mulai',
            'category_id'     => 'required|exists:categories,id',
            'stok_barang'     => 'required|integer|min:0',
        ]);

        $data = $request->only([
            'nama_lengkap','nim','prodi','nama_barang','description',
            'nup_ruangan','stok_barang','category_id'
        ]);

        $data['tanggal_mulai'] = Carbon::parse($request->tanggal_mulai)->format('Y-m-d');
        $data['tanggal_selesai'] = $request->tanggal_selesai
            ? Carbon::parse($request->tanggal_selesai)->format('Y-m-d')
            : null;

        $product->update($data);

        return redirect()->route('admin.products.index')->with('success', 'Barang berhasil diperbarui');
    }

    public function destroy(Product $product)
    {
        $product->delete();
        return redirect()->route('admin.products.index')->with('success', 'Barang berhasil dihapus');
    }
}
