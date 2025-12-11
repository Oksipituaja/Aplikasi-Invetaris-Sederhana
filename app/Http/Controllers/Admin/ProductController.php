<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use App\Models\User; 
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage; 
use Carbon\Carbon;
use Symfony\Component\HttpFoundation\Response; // Tambahkan untuk response streaming CSV

class ProductController extends Controller
{
    // Aturan Validasi untuk Store dan Update
    protected function validationRules()
    {
        // ... (KODE validationRules TIDAK BERUBAH) ...
        return [
            'user_id'       => 'nullable|exists:users,id',
            'nama_lengkap'  => 'required|string|max:255',
            'nim'           => 'nullable|string|max:20', 
            'prodi'         => 'required|string|max:100', 
            'phone_number'  => 'nullable|string|max:15', 
            'photo'         => 'nullable|image|max:2048', 
            
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
        // ... (KODE index TIDAK BERUBAH) ...
        $categories = Category::all();
        $productsQuery = Product::with('category');

        if ($request->filled('category_id')) {
            $productsQuery->where('category_id', $request->category_id);
        }

        $products = $productsQuery->latest()->get(); 
        return view('admin.products.index', compact('products', 'categories'));
    }

    // =========================================================
    // BARU: METHOD EXPORT CSV
    // =========================================================
    public function exportCsv(Request $request)
    {
        // 1. Ambil Data (Sama seperti index, termasuk filter kategori)
        $productsQuery = Product::with('category', 'user');

        if ($request->filled('category_id')) {
            $productsQuery->where('category_id', $request->category_id);
        }

        $products = $productsQuery->latest()->get();

        // 2. Buat Header CSV
        $filename = 'inventaris_admin_' . date('Ymd_His') . '.csv';
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"$filename\"",
        ];

        // Header kolom CSV
        $columns = [
            'No', 'Nama Barang', 'Kategori', 'Stok', 'Penanggung Jawab', 'NIM', 'Prodi', 
            'No. HP', 'NUP/Ruangan', 'Tanggal Mulai', 'Tanggal Selesai', 'Deskripsi'
        ];

        // 3. Proses Streaming Data
        $callback = function() use ($products, $columns) {
            $file = fopen('php://output', 'w');
            
            // Tulis Header Kolom
            fputcsv($file, $columns);
            
            $i = 1;
            foreach ($products as $product) {
                $row = [
                    $i++,
                    $product->nama_barang,
                    $product->category->nama_kategori ?? '-',
                    $product->stok_barang,
                    $product->nama_lengkap ?? ($product->user->name ?? '-'),
                    $product->nim ?? '-',
                    $product->prodi ?? '-',
                    $product->phone_number ?? '-',
                    $product->nup_ruangan ?? '-',
                    $product->tanggal_mulai ? Carbon::parse($product->tanggal_mulai)->format('Y-m-d') : '-',
                    $product->tanggal_selesai ? Carbon::parse($product->tanggal_selesai)->format('Y-m-d') : '-',
                    strip_tags($product->description)
                ];
                // Menggunakan separator ; jika default , bermasalah di Excel
                fputcsv($file, $row, ';'); 
            }
            fclose($file);
        };

        return Response::stream($callback, 200, $headers);
    }
    // =========================================================
    // END: METHOD EXPORT CSV
    // =========================================================

    public function create()
    {
        // ... (KODE create TIDAK BERUBAH) ...
        $categories = Category::all();
        $users = User::where('is_active', true)->orderBy('name')->get(); 
        return view('admin.products.form', compact('categories', 'users'));
    }

    public function store(Request $request)
    {
        // ... (KODE store TIDAK BERUBAH) ...
        $validated = $request->validate($this->validationRules());

        // 1. Handle File Upload (Photo)
        if ($request->hasFile('photo')) {
            $path = $request->file('photo')->store('products_photos', 'public');
            $validated['photo_path'] = $path;
        }

        Product::create($validated);

        return redirect()->route('admin.products.index')->with('success', 'Produk berhasil ditambahkan');
    }

    public function edit(Product $product)
    {
        // ... (KODE edit TIDAK BERUBAH) ...
        $categories = Category::all();
        $users = User::where('is_active', true)->orderBy('name')->get(); 
        return view('admin.products.form', compact('product', 'categories', 'users'));
    }

    public function update(Request $request, Product $product)
    {
        // ... (KODE update TIDAK BERUBAH) ...
        $validated = $request->validate($this->validationRules());
        
        // 1. Handle File Upload (Photo)
        if ($request->hasFile('photo')) {
            // Hapus foto lama jika ada
            if ($product->photo_path) {
                Storage::disk('public')->delete($product->photo_path);
            }
            $path = $request->file('photo')->store('products_photos', 'public');
            $validated['photo_path'] = $path;
        } 
        // else { ... } tidak perlu karena data yang divalidasi akan di-update, 
        // dan jika 'photo' kosong, 'photo_path' tidak akan ada di $validated,
        // sehingga nilai lama akan dipertahankan (kecuali jika ada input hidden untuk menghapus foto).
        // Karena tidak ada logika penghapusan foto jika input kosong, maka ini aman.

        $product->update($validated);

        return redirect()->route('admin.products.index')->with('success', 'Barang berhasil diperbarui');
    }

    public function destroy(Product $product)
    {
        // ... (KODE destroy TIDAK BERUBAH) ...
        if ($product->photo_path) {
            Storage::disk('public')->delete($product->photo_path);
        }
        
        $product->delete();
        return redirect()->route('admin.products.index')->with('success', 'Barang berhasil dihapus');
    }
}