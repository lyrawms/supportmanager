<?php

namespace App\Domains\Tasks\Models\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\{{ domainNamespacedModel }}>
 */
class TaskFactory extends Factory
{

    protected $model = \App\Domains\Tasks\Models\Task::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => $this->faker->sentence(),
            'description' => $this->faker->optional()->paragraph(),
            'intercom_link' => 'https://youtu.be/AzMo-FgRp64?si=OKjOLsg4XLJg72An',
            'created_at' => $createdAt = now(),
            'updated_at' => now(),
            'finished_at' => $this->faker->optional()->dateTime(),
            'sla' => $sla = $this->faker->randomDigitNotNull(),
            'status' => $this->faker->randomElement(['open', 'in_progress', 'completed']),
            'deadline' => $createdAt->copy()->addDays($sla),
            'creator_id' => User::factory(), // Assuming you're using the User factory
        ];
    }
}
