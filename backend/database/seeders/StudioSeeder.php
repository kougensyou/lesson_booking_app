<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Studio;

class StudioSeeder extends Seeder
{
    public function run()
    {
        Studio::insert([
            ['studio_name' => 'Tokyo Studio', 'studio_category_id' => 1],
            ['studio_name' => 'Yokohama Studio', 'studio_category_id' => 1],
            ['studio_name' => 'Osaka Studio', 'studio_category_id' => 2],
        ]);
    }
}