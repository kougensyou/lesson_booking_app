<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\LessonCategory;

class LessonCategorySeeder extends Seeder
{
    public function run()
    {
        LessonCategory::insert([
            ['id' => 1, 'category_name' => 'Pilates'],
            ['id' => 2, 'category_name' => 'Yoga'],
            ['id' => 3, 'category_name' => 'WorkShop'],
        ]);
    }
}