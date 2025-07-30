<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Support\Facades\Auth;

class UserProductController extends Controller
{
    public function index()
    {
        $products = Product::where('user_id', Auth::id())->with('category')->get();
        return view('user.products.index', compact('products'));
    }

    public function create()
    {
        $categories = Category::all();
        return view('user.products.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_barang' => 'required|string|max:255',
            'description' => 'nullable|string',
            'nup_ruangan' => 'required|string|max:255',
            'tanggal_mulai' => 'required|date',
            'tanggal_selesai' => 'nullable|date|after_or_equal:tanggal_mulai',
            'category_id' => 'required|exists:categories,id',
            'stok_barang' => 'required|integer|min:0',
        ]);

        $validated['user_id'] = Auth::id(); // tracking pemilik produk

        Product::create($validated);

        return redirect()->route('user.products.index')->with('success', 'Produk berhasil ditambahkan.');
    }

    public function show(string $id)
    {
        $product = Product::where('user_id', Auth::id())->findOrFail($id);
        return view('user.products.show', compact('product'));
    }

    public function edit(string $id)
    {
        $product = Product::where('user_id', Auth::id())->findOrFail($id);
        $categories = Category::all();
        return view('user.products.edit', compact('product', 'categories'));
    }

    public function update(Request $request, string $id)
    {
        $product = Product::where('user_id', Auth::id())->findOrFail($id);

        $validated = $request->validate([
            'nama_barang' => 'required|string|max:255',
            'description' => 'nullable|string',
            'nup_ruangan' => 'required|string|max:255',
            'tanggal_mulai' => 'required|date',
            'tanggal_selesai' => 'nullable|date|after_or_equal:tanggal_mulai',
            'category_id' => 'required|exists:categories,id',
            'stok_barang' => 'required|integer|min:0',
        ]);

        $product->update($validated);

        return redirect()->route('user.products.index')->with('success', 'Produk berhasil diperbarui.');
    }

    public function destroy(string $id)
    {
        $product = Product::where('user_id', Auth::id())->findOrFail($id);
        $product->delete();

        return redirect()->route('user.products.index')->with('success', 'Produk berhasil dihapus.');
    }
}