<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Info;

class InfoSeeder extends Seeder
{
    public function run()
    {
        Info::insert([
            ['name' => 'Info6', 'image_path' => '/images/info/orange_banner.png', 'kind' => 2, 'link_url' => '', 'visible_flag' => false, 'sort_order' => 11],
            ['name' => 'Info8', 'image_path' => '/images/info/orange_banner.png', 'kind' => 2, 'link_url' => '', 'visible_flag' => false, 'sort_order' => 12],
            ['name' => 'Info8', 'image_path' => '', 'kind' => 2, 'link_url' => '', 'visible_flag' => true, 'sort_order' => 1],
            ['name' => 'Info9', 'image_path' => '', 'kind' => 1, 'link_url' => 'https://www.example.com/', 'visible_flag' => true, 'sort_order' => 2],
            ['name' => 'Info3', 'image_path' => '/images/info/orange_banner.png', 'kind' => 1, 'link_url' => 'https://www.tesla.com/', 'visible_flag' => true, 'sort_order' => 3],
            ['name' => '運営会社', 'image_path' => '', 'kind' => 3, 'link_url' => 'https://www.google.com/', 'visible_flag' => true, 'sort_order' => 13],
            ['name' => '採用情報', 'image_path' => '', 'kind' => 3, 'link_url' => 'https://www.example.com/', 'visible_flag' => true, 'sort_order' => 14],
            ['name' => 'おすすめピラティス・ヨガ資格', 'image_path' => '', 'kind' => 3, 'link_url' => 'https://www.example.com/', 'visible_flag' => true, 'sort_order' => 15],
            ['name' => 'ピラティスヨガグッズ', 'image_path' => '', 'kind' => 3, 'link_url' => 'https://www.example.com/', 'visible_flag' => true, 'sort_order' => 16],
            ['name' => 'ピラティスヨガグッズ', 'image_path' => '', 'kind' => 3, 'link_url' => '', 'visible_flag' => true, 'sort_order' => 17],
            ['name' => 'コラム', 'image_path' => '', 'kind' => 3, 'link_url' => '', 'visible_flag' => true, 'sort_order' => 18],
            ['name' => 'Info1', 'image_path' => '/images/info/blue_banner.png', 'kind' => 1, 'link_url' => 'https://www.google.com/', 'visible_flag' => true, 'sort_order' => 4],
            ['name' => 'Info5', 'image_path' => '/images/info/purple_banner.png', 'kind' => 1, 'link_url' => '', 'visible_flag' => true, 'sort_order' => 5],
            ['name' => 'Info3', 'image_path' => '/images/info/orange_banner.png', 'kind' => 1, 'link_url' => 'https://www.tesla.com/', 'visible_flag' => true, 'sort_order' => 6],
            ['name' => 'Info2', 'image_path' => '/images/info/orange_banner.png', 'kind' => 2, 'link_url' => 'https://www.example.com/', 'visible_flag' => true, 'sort_order' => 9],
            ['name' => 'Info4', 'image_path' => '/images/info/orange_banner.png', 'kind' => 2, 'link_url' => 'https://www.example.com/', 'visible_flag' => true, 'sort_order' => 10],
            ['name' => 'Info1', 'image_path' => '/images/info/blue_banner.png', 'kind' => 1, 'link_url' => 'https://www.google.com/', 'visible_flag' => true, 'sort_order' => 7],
            ['name' => 'Info5', 'image_path' => '/images/info/purple_banner.png', 'kind' => 1, 'link_url' => '', 'visible_flag' => true, 'sort_order' => 8],
        ]);
    }
}
