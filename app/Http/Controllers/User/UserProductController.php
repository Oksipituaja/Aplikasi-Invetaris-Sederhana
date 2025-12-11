<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon; // Tambahkan untuk format tanggal
use Symfony\Component\HttpFoundation\Response; // Tambahkan untuk response streaming CSV

class UserProductController extends Controller
{
    // Aturan Validasi untuk Store dan Update User
    protected function validationRules($isUpdate = false)
    {
        // ... (KODE validationRules TIDAK BERUBAH) ...
        return [
            'nama_lengkap' => 'required|string|max:255',
            'nim' => 'required|string|max:20',
            'prodi' => 'required|string|max:100',
            'phone_number' => 'required|string|max:15', 
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
        // ... (KODE index TIDAK BERUBAH) ...
        $products = Auth::user()->products()->latest()->get();
        return view('user.products.index', compact('products'));
    }

    // =========================================================
    // BARU: METHOD EXPORT CSV
    // =========================================================
    public function exportCsv()
    {
        // 1. Ambil Data User yang Sedang Login
        $products = Auth::user()->products()->with('category')->latest()->get();

        // 2. Buat Header CSV
        $filename = 'inventaris_saya_' . date('Ymd_His') . '.csv';
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
            fputcsv($file, $columns);
            
            $i = 1;
            foreach ($products as $product) {
                $row = [
                    $i++,
                    $product->nama_barang,
                    $product->category->nama_kategori ?? '-',
                    $product->stok_barang,
                    $product->nama_lengkap ?? (Auth::user()->name ?? '-'),
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
        return view('user.products.create', compact('categories'));
    }

    public function store(Request $request)
    {
        // ... (KODE store TIDAK BERUBAH) ...
        $validatedData = $request->validate($this->validationRules());
        
        // 1. Handle File Upload (Photo)
        if ($request->hasFile('photo')) {
            $path = $request->file('photo')->store('products_photos', 'public');
            $validatedData['photo_path'] = $path;
        }

        $validatedData['user_id'] = Auth::id(); 
        Product::create($validatedData);

        return redirect()->route('user.products.index')->with('success', 'Produk berhasil ditambahkan!');
    }

    public function edit(Product $product)
    {
        // ... (KODE edit TIDAK BERUBAH) ...
        if ($product->user_id !== Auth::id()) abort(403, 'Akses Ditolak');
        
        $categories = Category::all();
        return view('user.products.edit', compact('product', 'categories'));
    }

    public function update(Request $request, Product $product)
    {
        // ... (KODE update TIDAK BERUBAH) ...
        if ($product->user_id !== Auth::id()) abort(403, 'Akses Ditolak');
        
        $validatedData = $request->validate($this->validationRules(true));
        
        // 1. Handle File Upload (Photo)
        if ($request->hasFile('photo')) {
            if ($product->photo_path) {
                Storage::disk('public')->delete($product->photo_path);
            }
            $path = $request->file('photo')->store('products_photos', 'public');
            $validatedData['photo_path'] = $path; 
        }
        
        $product->update($validatedData);
        
        return redirect()->route('user.products.index')->with('success', 'Update berhasil');
    }

    public function destroy(Product $product)
    {
        // ... (KODE destroy TIDAK BERUBAH) ...
        if ($product->user_id !== Auth::id()) abort(403, 'Akses Ditolak');
        
        if ($product->photo_path) {
            Storage::disk('public')->delete($product->photo_path);
        }
        
        $product->delete();
        
        return redirect()->route('user.products.index')->with('success', 'Hapus berhasil');
    }
}