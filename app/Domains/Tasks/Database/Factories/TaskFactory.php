<?php

namespace App\Domains\Tasks\Database\Factories;
use App\Domains\Tasks\Database\Models\Task;
use App\Domains\Users\Database\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class TaskFactory extends Factory
{
    protected $model = Task::class;

    public function definition(): array
    {
        return [
            'title' => $this->faker->sentence(),
            'description' => $this->faker->optional()->paragraph(),
            'intercom_link' => $this->faker->optional()->url(),
            'created_at' => $createdAt = Carbon::parse($this->faker->dateTimeBetween('-1 year', 'now'))->copy(),
            'updated_at' => now(),
            'finished_at' => $this->faker->optional()->dateTime(),
            'sla' => $sla = $this->faker->randomDigitNotNull(),
            'status' => $this->faker->randomElement(['open', 'in_progress', 'completed']),
            'deadline' => $createdAt->copy()->addDays($sla),
            'creator_id' => User::factory(),
        ];
    }
}
