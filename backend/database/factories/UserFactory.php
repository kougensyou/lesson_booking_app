<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class UserFactory extends Factory
{
    /**
     * モデルのデフォルト状態の定義
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->name(),
            'age' => rand(1, 100),
            'email' => $this->faker->unique()->safeEmail(),
            'user_type' => 0,
            'remember_token' => Str::random(10),
        ];
    }
}
