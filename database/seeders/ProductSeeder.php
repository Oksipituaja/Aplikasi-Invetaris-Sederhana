<?php

namespace Database\Seeders;
use App\Models\Product;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Product::create([
            "name"=> "Produk 1",
            "description"=> "Deskripsi Produk",
            "sku"=> "#1234",
            "price"=> 10000,
            "category_id"=> 1,
            "stock"=> 100
        ]);
    }
}
