<?php

namespace App\Domains\Teams\Database\Factories;

use App\Domains\Teams\Database\Models\Team;
use App\Domains\Users\Database\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;


class TeamFactory extends Factory
{
    protected $model = Team::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->unique()->company(),
            'user_id' => User::factory(),
            'personal_team' => true,
        ];
    }
}
