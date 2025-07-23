<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = ['nama_barang'];

    public function products()
    {
        return $this->hasMany(Product::class);
    }
}

