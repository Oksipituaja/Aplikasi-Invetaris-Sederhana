<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Product extends Model
{
    protected $fillable = [
        'nama_lengkap','nim','prodi','nama_barang','description',
        'nup_ruangan','tanggal_mulai','tanggal_selesai',
        'stok_barang','category_id','user_id'
    ];

    // FIX: Tambahkan properti $casts untuk mengkonversi kolom tanggal menjadi objek Carbon
    protected $casts = [
        'tanggal_mulai' => 'datetime',
        'tanggal_selesai' => 'datetime',
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}