<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Info;

class InfoSeeder extends Seeder
{
    public function run()
    {
        Info::insert([
            ['name' => 'Info1', 'image_path' => 'images/blue_banner.png', 'kind' => '1', 'link_url' => 'https://www.google.com/'],
            ['name' => 'Info2', 'image_path' => '', 'kind' => '2', 'link_url' => 'https://www.example.com/'],
            ['name' => 'Info3', 'image_path' => 'images/orange_banner.png', 'kind' => '1', 'link_url' => 'https://www.tesla.com/'],
            ['name' => 'Info4', 'image_path' => '', 'kind' => '2', 'link_url' => 'https://www.example.com/'],
            ['name' => 'Info5', 'image_path' => 'images/purple_banner.png', 'kind' => '1', 'link_url' => ''],
            ['name' => 'Info6', 'image_path' => '', 'kind' => '2', 'link_url' => ''],
            ['name' => 'Info7', 'image_path' => '', 'kind' => '1', 'link_url' => ''],
            ['name' => 'Info8', 'image_path' => '', 'kind' => '2', 'link_url' => ''],
            ['name' => 'Info9', 'image_path' => '', 'kind' => '1', 'link_url' => 'https://www.example.com/'],
        ]);
    }
}
