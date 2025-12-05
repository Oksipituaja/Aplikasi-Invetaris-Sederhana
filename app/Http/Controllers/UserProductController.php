<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

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
            'nama_lengkap'    => 'required|string|max:255',
            'nim'             => 'required|string|max:50',
            'prodi'           => 'required|string|max:100',
            'nama_barang'     => 'required|string|max:255',
            'description'     => 'nullable|string',
            'nup_ruangan'     => 'required|string|max:255',
            'tanggal_mulai'   => 'required|date',
            'tanggal_selesai' => 'nullable|date|after_or_equal:tanggal_mulai',
            'category_id'     => 'required|exists:categories,id',
            'stok_barang'     => 'required|integer|min:0',
        ]);

        $validated['tanggal_mulai'] = Carbon::parse($request->tanggal_mulai)->format('Y-m-d');
        $validated['tanggal_selesai'] = $request->tanggal_selesai
            ? Carbon::parse($request->tanggal_selesai)->format('Y-m-d')
            : null;

        $validated['user_id'] = Auth::id();

        Product::create($validated);

        return redirect()->route('user.products.index')->with('success', 'Produk berhasil ditambahkan.');
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
            'nama_lengkap'    => 'required|string|max:255',
            'nim'             => 'required|string|max:50',
            'prodi'           => 'required|string|max:100',
            'nama_barang'     => 'required|string|max:255',
            'description'     => 'nullable|string',
            'nup_ruangan'     => 'required|string|max:255',
            'tanggal_mulai'   => 'required|date',
            'tanggal_selesai' => 'nullable|date|after_or_equal:tanggal_mulai',
            'category_id'     => 'required|exists:categories,id',
            'stok_barang'     => 'required|integer|min:0',
        ]);

        $validated['tanggal_mulai'] = Carbon::parse($request->tanggal_mulai)->format('Y-m-d');
        $validated['tanggal_selesai'] = $request->tanggal_selesai
            ? Carbon::parse($request->tanggal_selesai)->format('Y-m-d')
            : null;

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
