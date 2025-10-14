<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Info;

class InfoSeeder extends Seeder
{
    public function run()
    {
        Info::insert([
            ['name' => 'Info6', 'image_path' => '/images/info/banner_01.png', 'kind' => 2, 'link_url' => '', 'visible_flag' => false, 'sort_order' => 11],
            ['name' => 'Info8', 'image_path' => '/images/info/banner_01.png', 'kind' => 2, 'link_url' => '', 'visible_flag' => false, 'sort_order' => 12],
            ['name' => 'Info8', 'image_path' => '/images/info/banner_03.png', 'kind' => 2, 'link_url' => '', 'visible_flag' => true, 'sort_order' => 1],
            ['name' => 'Info9', 'image_path' => '/images/info/banner_04.png', 'kind' => 1, 'link_url' => 'https://vuejs.org/', 'visible_flag' => true, 'sort_order' => 2],
            ['name' => 'Info3', 'image_path' => '/images/info/banner_01.png', 'kind' => 1, 'link_url' => 'https://laravel.com/', 'visible_flag' => true, 'sort_order' => 3],
            ['name' => 'Company Information', 'image_path' => '', 'kind' => 3, 'link_url' => 'https://www.google.com/', 'visible_flag' => true, 'sort_order' => 13],
            ['name' => 'Career', 'image_path' => '', 'kind' => 3, 'link_url' => 'https://vuejs.org/', 'visible_flag' => true, 'sort_order' => 14],
            ['name' => 'Recommended Pilates Yoga Certificates', 'image_path' => '', 'kind' => 3, 'link_url' => 'https://vuejs.org/', 'visible_flag' => true, 'sort_order' => 15],
            ['name' => 'Pilates Yoga Items', 'image_path' => '', 'kind' => 3, 'link_url' => 'https://vuejs.org/', 'visible_flag' => true, 'sort_order' => 16],
            ['name' => 'Pilates Yoga Goods', 'image_path' => '', 'kind' => 3, 'link_url' => '', 'visible_flag' => true, 'sort_order' => 17],
            ['name' => 'Column', 'image_path' => '', 'kind' => 3, 'link_url' => '', 'visible_flag' => true, 'sort_order' => 18],
            ['name' => 'Info1', 'image_path' => '/images/info/banner_03.png', 'kind' => 1, 'link_url' => 'https://www.google.com/', 'visible_flag' => true, 'sort_order' => 4],
            ['name' => 'Info5', 'image_path' => '/images/info/banner_04.png', 'kind' => 1, 'link_url' => '', 'visible_flag' => true, 'sort_order' => 5],
            ['name' => 'Info3', 'image_path' => '/images/info/banner_01.png', 'kind' => 1, 'link_url' => 'https://laravel.com/', 'visible_flag' => true, 'sort_order' => 6],
            ['name' => 'Info2', 'image_path' => '/images/info/banner_01.png', 'kind' => 2, 'link_url' => 'https://vuejs.org/', 'visible_flag' => true, 'sort_order' => 9],
            ['name' => 'Info4', 'image_path' => '/images/info/banner_01.png', 'kind' => 2, 'link_url' => 'https://vuejs.org/', 'visible_flag' => true, 'sort_order' => 10],
            ['name' => 'Info1', 'image_path' => '/images/info/banner_03.png', 'kind' => 1, 'link_url' => 'https://www.google.com/', 'visible_flag' => true, 'sort_order' => 7],
            ['name' => 'Info5', 'image_path' => '/images/info/banner_04.png', 'kind' => 1, 'link_url' => '', 'visible_flag' => true, 'sort_order' => 8],
        ]);
    }
}
