<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Carbon\Carbon;

class ProductController extends Controller
{
    protected function parseDateInput(?string $value): ?Carbon
    {
        if (!$value) return null;
        $value = trim($value);

        $formats = [
            'd/m/Y h:i A',
            'd/m/Y H:i',
            'Y-m-d H:i',
            'Y-m-d H:i:s',
            'd-m-Y H:i',
            'd-m-Y h:i A',
        ];

        foreach ($formats as $f) {
            try {
                return Carbon::createFromFormat($f, $value);
            } catch (\Exception $e) {}
        }

        try {
            return Carbon::parse($value);
        } catch (\Exception $e) {
            return null;
        }
    }

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
            'tanggal_mulai'   => 'required|string',
            'tanggal_selesai' => 'nullable|string',
            'category_id'     => 'required|exists:categories,id',
            'stok_barang'     => 'required|integer|min:0',
        ]);

        $data = $request->only([
            'nama_lengkap','nim','prodi','nama_barang','description',
            'nup_ruangan','tanggal_mulai','tanggal_selesai','stok_barang','category_id'
        ]);

        $mulai = $this->parseDateInput($request->tanggal_mulai);
        $selesai = $this->parseDateInput($request->tanggal_selesai);

        if (!$mulai) {
            return back()->withErrors(['tanggal_mulai' => 'Format tanggal mulai tidak valid.'])->withInput();
        }

        $data['tanggal_mulai'] = $mulai->format('Y-m-d H:i:s');
        $data['tanggal_selesai'] = $selesai ? $selesai->format('Y-m-d H:i:s') : null;

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
            'tanggal_mulai'   => 'required|string',
            'tanggal_selesai' => 'nullable|string',
            'category_id'     => 'required|exists:categories,id',
            'stok_barang'     => 'required|integer|min:0',
        ]);

        $data = $request->only([
            'nama_lengkap','nim','prodi','nama_barang','description',
            'nup_ruangan','tanggal_mulai','tanggal_selesai','stok_barang','category_id'
        ]);

        $mulai = $this->parseDateInput($request->tanggal_mulai);
        $selesai = $this->parseDateInput($request->tanggal_selesai);

        if (!$mulai) {
            return back()->withErrors(['tanggal_mulai' => 'Format tanggal mulai tidak valid.'])->withInput();
        }

        $data['tanggal_mulai'] = $mulai->format('Y-m-d H:i:s');
        $data['tanggal_selesai'] = $selesai ? $selesai->format('Y-m-d H:i:s') : null;

        $product->update($data);

        return redirect()->route('admin.products.index')->with('success', 'Barang berhasil diperbarui');
    }

    public function destroy(Product $product)
    {
        $product->delete();
        return redirect()->route('admin.products.index')->with('success', 'Barang berhasil dihapus');
    }
}
