<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Modifikasi tabel products yang sudah ada
        Schema::table('products', function (Blueprint $table) {
            // Tambahkan kolom phone_number (VARCHAR 15, boleh kosong)
            $table->string('phone_number', 15)->nullable()->after('prodi'); 
            
            // Tambahkan kolom photo_path (VARCHAR 255, boleh kosong)
            $table->string('photo_path')->nullable()->after('phone_number');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            // Hapus kedua kolom jika dilakukan rollback
            $table->dropColumn(['phone_number', 'photo_path']);
        });
    }
};