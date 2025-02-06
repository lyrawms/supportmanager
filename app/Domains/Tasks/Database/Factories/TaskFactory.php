<?php

<<<<<<<< HEAD:app/Domains/Tasks/Database/Factories/TaskFactory.php
namespace App\Domains\Tasks\Database\Factories;
========
namespace App\Domains\Tasks\Models\Factories;
>>>>>>>> ui-improvement:app/Domains/Tasks/Models/Factories/TaskFactory.php

use App\Domains\Tasks\Database\Models\Task;
use App\Domains\Users\Database\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class TaskFactory extends Factory
{

<<<<<<<< HEAD:app/Domains/Tasks/Database/Factories/TaskFactory.php
    protected $model = Task::class;


========
    protected $model = \App\Domains\Tasks\Models\Task::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
>>>>>>>> ui-improvement:app/Domains/Tasks/Models/Factories/TaskFactory.php
    public function definition(): array
    {
        return [
            'title' => $this->faker->sentence(),
            'description' => $this->faker->optional()->paragraph(),
<<<<<<<< HEAD:app/Domains/Tasks/Database/Factories/TaskFactory.php
            'intercom_link' => $this->faker->optional()->url(),
            'created_at' => $createdAt = Carbon::parse($this->faker->dateTimeBetween('-1 year', 'now'))->copy(),
========
            'intercom_link' => 'https://youtu.be/AzMo-FgRp64?si=OKjOLsg4XLJg72An',
            'created_at' => $createdAt = now(),
>>>>>>>> ui-improvement:app/Domains/Tasks/Models/Factories/TaskFactory.php
            'updated_at' => now(),
            'finished_at' => $this->faker->optional()->dateTime(),
            'sla' => $sla = $this->faker->randomDigitNotNull(),
            'status' => $this->faker->randomElement(['open', 'in_progress', 'completed']),
            'deadline' => $createdAt->copy()->addDays($sla),
            'creator_id' => User::factory(),
        ];
    }
}
