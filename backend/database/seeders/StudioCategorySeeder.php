<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\StudioCategory;

class StudioCategorySeeder extends Seeder
{
    public function run()
    {
        StudioCategory::insert([
            ['category_name' => 'Grade_1'],
            ['category_name' => 'Grade_2'],
        ]);
    }
}