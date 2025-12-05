<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Tambahkan kolom stok_barang ke tabel products.
     */
    public function up(): void
    {
        Schema::table('products', function (Blueprint $table) {
            // Pastikan kolom belum ada sebelum ditambahkan
            if (!Schema::hasColumn('products', 'stok_barang')) {
                $table->integer('stok_barang')
                      ->default(0)
                      ->after('tanggal_selesai')
                      ->comment('Jumlah stok barang tersedia');
            }
        });
    }

    /**
     * Hapus kolom stok_barang saat rollback.
     */
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            if (Schema::hasColumn('products', 'stok_barang')) {
                $table->dropColumn('stok_barang');
            }
        });
    }
};
