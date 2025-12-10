<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Product extends Model
{
    protected $fillable = [
        'nama_lengkap','nim','prodi','nama_barang','description',
        'nup_ruangan','tanggal_mulai','tanggal_selesai',
        'stok_barang','category_id','user_id' // user_id KRUSIAL untuk penyimpanan
    ];

    // FIX UTAMA: Baris ini mewajibkan Laravel mengubah string database jadi objek tanggal (Carbon)
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
