<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Inventaris extends Model
{
    use HasFactory;

    protected $table = 'inventaris'; // Nama tabel eksplisit

    protected $fillable = [
        'nama_lengkap','nim','prodi',
        'kode_barang',
        'nama_barang',
        'kategori',
        'lokasi',
        'kondisi',
        'deskripsi',
    ];
}