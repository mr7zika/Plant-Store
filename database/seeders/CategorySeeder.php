<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Category::create([
            'name' => 'نباتات داخلية',
            'description' => 'نباتات مناسبة للأماكن المغلقة والمنازل',
        ]);

        Category::create([
            'name' => 'نباتات خارجية',
            'description' => 'نباتات مناسبة للحدائق والأماكن المفتوحة',
        ]);

        Category::create([
            'name' => 'نباتات عطرية',
            'description' => 'نباتات عطرية وطبية',
        ]);

        Category::create([
            'name' => 'نباتات نادرة',
            'description' => 'نباتات نادرة وغريبة',
        ]);

        Category::create([
            'name' => 'أشجار مثمرة',
            'description' => 'أشجار تثمر وتنتج فواكه',
        ]);
    }
}

