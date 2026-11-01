<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // تم تعطيل إنشاء المستخدم لأنه موجود بالفعل لتجنب خطأ التكرار
        /*
        \App\Models\User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);
        */

        // استدعاء ملفات المنتجات والتصنيفات الوهمية
        $this->call([
            CategorySeeder::class,
            ProductSeeder::class,
        ]);
    }
}