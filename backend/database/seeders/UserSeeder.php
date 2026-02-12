<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class UserSeeder extends Seeder
{
    public function run()
    {
        User::insert([
            [
                'name' => 'test1',
                'email' => 'test1@example.com',
                'password' => bcrypt('cocokarasys1'),
                'birth_date' => '1995-01-01',
                'image_path' => '/images/user/test1_profile.png',
                'zip_code' => '123-4567',
                'tel_no' => '080-1234-5678',
                'address' => 'Tokyo Chiyoda 1-1-1'
            ],
            [
                'name' => 'test2',
                'email' => 'test2@example.com',
                'password' => bcrypt('testtest2'),
                'birth_date' => '1992-02-02',
                'image_path' => '/images/user/test2_profile.png',
                'zip_code' => '234-5678',
                'tel_no' => '080-2345-6789',
                'address' => 'Tokyo Chiyoda 2-2-2'
            ],
            [
                'name' => 'test3',
                'email' => 'test3@example.com',
                'password' => bcrypt('testtest3'),
                'birth_date' => '1994-03-03',
                'image_path' => '/images/user/test3_profile.png',
                'zip_code' => '345-6789',
                'tel_no' => '080-3456-7890',
                'address' => 'Tokyo Chiyoda 3-3-3'
            ],
        ]);
    }
}