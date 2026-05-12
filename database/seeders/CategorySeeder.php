<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            'Nusantara',
            'Seafood',
            'Western',
            'Dessert',
            'Fast Food',
            'Minuman & Kopi',
            'Mie & Pasta',
            'Hidangan Berkuah',
            'Olahan Daging',
            'Camilan',
        ];

        foreach ($categories as $category) {
            Category::updateOrCreate(
                ['nama_kategori' => $category],
                ['nama_kategori' => $category]
            );
        }
    }
}
