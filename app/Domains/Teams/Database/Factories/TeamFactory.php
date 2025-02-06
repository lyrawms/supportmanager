<?php

namespace App\Domains\Teams\Database\Factories;

use App\Domains\Users\Database\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;


class TeamFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->unique()->company(),
            'user_id' => User::factory(),
            'personal_team' => true,
        ];
    }
}
