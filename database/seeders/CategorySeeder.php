<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        Category::insert([
            ['name' => 'Elektronik'],
            ['name' => 'Peralatan Dapur'],
            ['name' => 'Kantor'],
            ['name' => 'Lainnya'],
        ]);
    }
}
