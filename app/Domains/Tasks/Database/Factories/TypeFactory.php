<?php

namespace App\Domains\Tasks\Database\Factories;

use App\Domains\Tasks\Database\Models\Type;
use App\Domains\Users\Database\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;


class TypeFactory extends Factory
{
 protected $model = Type::class;


    public function definition(): array
    {
        return [
            'title' => $this->faker->unique()->word(),
            'color' => $this->faker->hexColor(),
            'creator_id' => User::factory(),
            'sla' => $this->faker->numberBetween(1, 10),
        ];
    }
}
