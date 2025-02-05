<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;


class TypeFactory extends Factory
{



    public function definition(): array
    {
        return [
            'title' => $this->faker->unique()->word(),
            'color' => $this->faker->hexColor(),
            'creator_id' => User::factory(),
        ];
    }
}
