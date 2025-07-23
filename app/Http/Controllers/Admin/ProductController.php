<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;

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
            'nama_barang'     => 'required|string|max:255',
            'description'     => 'nullable|string',
            'nup_ruangan'     => 'required|string|max:255',
            'tanggal_mulai'   => 'required|date',
            'tanggal_selesai' => 'nullable|date',
            'category_id'     => 'required|exists:categories,id',
            'stok_barang'     => 'required|integer|min:0',
        ]);

        Product::create($request->only([
            'nama_barang',
            'description',
            'nup_ruangan',
            'tanggal_mulai',
            'tanggal_selesai',
            'stok_barang',
            'category_id'
        ]));

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
            'nama_barang'     => 'required|string|max:255',
            'description'     => 'nullable|string',
            'nup_ruangan'     => 'required|string|max:255',
            'tanggal_mulai'   => 'required|date',
            'tanggal_selesai' => 'nullable|date',
            'category_id'     => 'required|exists:categories,id',
            'stok_barang'     => 'required|integer|min:0',
        ]);

        $product->update($request->only([
            'nama_barang',
            'description',
            'nup_ruangan',
            'tanggal_mulai',
            'tanggal_selesai',
            'category_id',
            'stok_barang',
        ]));

        return redirect()->route('admin.products.index')->with('success', 'Barang berhasil diperbarui');
    }

    public function destroy(Product $product)
    {
        $product->delete();
        return redirect()->route('admin.products.index')->with('success', 'Barang berhasil dihapus');
    }
}
