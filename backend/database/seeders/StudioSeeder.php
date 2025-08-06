<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Studio;

class StudioSeeder extends Seeder
{
    public function run()
    {
        Studio::insert([
            ['studio_name' => 'Tokyo Studio', 'image_path' => '/images/studio/studio_1.png'],
            ['studio_name' => 'Yokohama Studio', 'image_path' => '/images/studio/studio_2.png'],
            ['studio_name' => 'Osaka Studio', 'image_path' => '/images/studio/studio_3.png'],
        ]);
    }
}