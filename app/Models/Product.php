<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'nama_barang', 'description', 'nup_ruangan', 'tanggal_mulai',
        'tanggal_selesai', 'stok_barang', 'category_id'
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
