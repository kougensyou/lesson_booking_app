<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\FavoriteStudio;

class FavoriteStudioSeeder extends Seeder
{
    public function run()
    {
        FavoriteStudio::insert([
            [
                'user_id' => 1,
                'studio_id' => 101,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'user_id' => 2,
                'studio_id' => 102,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'user_id' => 3,
                'studio_id' => 103,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ]);
    }
}