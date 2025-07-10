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
                'password' => bcrypt('testtest1'),
            ],
            [
                'name' => 'test2',
                'email' => 'test2@example.com',
                'password' => bcrypt('testtest2'),
            ],
            [
                'name' => 'test3',
                'email' => 'test3@example.com',
                'password' => bcrypt('testtest3'),
            ],
        ]);
    }
}