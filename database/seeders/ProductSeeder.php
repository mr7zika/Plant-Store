<?php

namespace Database\Seeders;

use App\Models\Category;
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
        $indoorCategory = Category::where('name', 'نباتات داخلية')->first();
        $rareCategory = Category::where('name', 'نباتات نادرة')->first();
        $fruitCategory = Category::where('name', 'أشجار مثمرة')->first();

        Product::create([
            'name' => 'نبات الصبار الأخضر',
            'price' => 45.99,
            'quantity' => 15,
            'category_id' => $indoorCategory->id ?? 1,
            'description' => 'نبات صبار طبيعي جميل وسهل العناية به. يتحمل الجفاف والظروف القاسية.',
            'image' => null,
            'video' => null,
        ]);

        Product::create([
            'name' => 'وردة جورية حمراء',
            'price' => 89.99,
            'quantity' => 8,
            'category_id' => $rareCategory->id ?? 4,
            'description' => 'وردة جورية عطرية بلون أحمر زاهي. تدوم فترة طويلة وتتطلب رعاية بسيطة.',
            'image' => null,
            'video' => null,
        ]);

        Product::create([
            'name' => 'شجرة التين المصغرة',
            'price' => 125.00,
            'quantity' => 5,
            'category_id' => $fruitCategory->id ?? 5,
            'description' => 'شجرة تين مصغرة مثالية للمنزل. تثمر وتنمو بسرعة.',
            'image' => null,
            'video' => null,
        ]);
    }
}


