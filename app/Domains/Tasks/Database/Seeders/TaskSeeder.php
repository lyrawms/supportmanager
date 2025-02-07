<?php

namespace App\Domains\Tasks\Database\Seeders;

use App\Domains\Tasks\Database\Models\Task;
use App\Domains\Users\Database\Models\User;
use Illuminate\Database\Seeder;

class TaskSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::all()->each(function (User $user) {
            $type = $user->types()->inRandomOrder()->first();
            Task::factory(5)->create([
                'creator_id' => $user->id,
                'type_id' => $type->id,
            ]);
        });
    }
}
