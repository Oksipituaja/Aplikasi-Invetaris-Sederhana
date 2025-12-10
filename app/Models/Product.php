<?php

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Product extends Model
{
    protected $fillable = [
        // 1. DATA PENANGGUNG JAWAB BARU
        'user_id', 
        'nama_lengkap',
        'nim',
        'prodi',
        'phone_number', // <--- WAJIB DITAMBAHKAN
        'photo_path',   // <--- WAJIB DITAMBAHKAN
        
        // 2. DATA BARANG LAMA
        'nama_barang',
        'description',
        'nup_ruangan',
        'tanggal_mulai',
        'tanggal_selesai',
        'stok_barang',
        'category_id',
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
