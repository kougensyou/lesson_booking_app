<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Instructor;

class InstructorSeeder extends Seeder
{
    public function run()
    {
        Instructor::insert([
            ['name' => 'Arisa', 'image_path' => '/images/instructor/arisa.png', 'studio_id' => 1, 'introduction' => 'I live with my parents and three cats, and I have one sibling. I played basketball from elementary school through university, and I still play whenever I have time! My hobbies are watching movies at home, staying active, and eating delicious food.', 'from_place' => 'Tokyo'],
            ['name' => 'Juria', 'image_path' => '/images/instructor/juria.png', 'studio_id' => 1, 'introduction' => 'Through Pilates, I was able to strengthen my inner muscles and develop a sense of the body’s core axis, which is important in figure skating. I will do my best to share the benefits of Pilates with both athletes and non-athletes alike!', 'from_place' => 'Osaka'],
            ['name' => 'Miya', 'image_path' => '/images/instructor/miya.png', 'studio_id' => 1, 'introduction' => 'I hope to practice Pilates together with everyone, taking care of our bodies and enjoying it with smiles. I want to keep learning Pilates together while having fun.', 'from_place' => 'Fukuoka'],
        ]);
    }
}