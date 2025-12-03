<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Log extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama_lengkap','nim','prodi',
        'tanggal',
        'nama_barang',
        'jumlah',
        'keterangan',
    ];
}
