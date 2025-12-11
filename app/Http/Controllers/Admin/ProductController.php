<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use App\Models\User; 
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage; 
use Carbon\Carbon;
use Symfony\Component\HttpFoundation\Response; // PASTIKAN INI ADA

class ProductController extends Controller
{
    // ... (metode validationRules, index, create, store, edit, update, destroy)

    // BARU: METHOD EXPORT CSV
    public function exportCsv(Request $request)
    {
        $productsQuery = Product::with('category', 'user');

        if ($request->filled('category_id')) {
            $productsQuery->where('category_id', $request->category_id);
        }

        $products = $productsQuery->latest()->get();

        $filename = 'inventaris_admin_' . date('Ymd_His') . '.csv';
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"$filename\"",
        ];

        $columns = [
            'No', 'Nama Barang', 'Kategori', 'Stok', 'Penanggung Jawab', 'NIM', 'Prodi', 
            'No. HP', 'NUP/Ruangan', 'Tanggal Mulai', 'Tanggal Selesai', 'Deskripsi'
        ];

        $callback = function() use ($products, $columns) {
            $file = fopen('php://output', 'w');
            fputcsv($file, $columns);
            
            $i = 1;
            foreach ($products as $product) {
                // Perbaikan Penanganan Nama PJ
                $pj_name = $product->nama_lengkap ?? ($product->user ? $product->user->name : '-');
                
                $row = [
                    $i++,
                    $product->nama_barang,
                    $product->category->nama_kategori ?? '-',
                    $product->stok_barang,
                    $pj_name, // Gunakan variabel yang sudah diperbaiki
                    $product->nim ?? '-',
                    $product->prodi ?? '-',
                    $product->phone_number ?? '-',
                    $product->nup_ruangan ?? '-',
                    $product->tanggal_mulai ? Carbon::parse($product->tanggal_mulai)->format('Y-m-d') : '-',
                    $product->tanggal_selesai ? Carbon::parse($product->tanggal_selesai)->format('Y-m-d') : '-',
                    strip_tags($product->description)
                ];
                fputcsv($file, $row, ';'); 
            }
            fclose($file);
        };

        return Response::stream($callback, 200, $headers);
    }
    // ...
}