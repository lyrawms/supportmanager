<?php

namespace Database\Seeders;

use App\Domains\Tasks\Database\Models\Task;
use App\Domains\Tasks\Database\Models\Type;
use App\Models\User;
use Illuminate\Database\Seeder;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        User::factory()->withPersonalTeam()->create([
            'name' => 'Test User',
            'email' => 'test@test.nl',
            'password' => bcrypt('password'),
        ]);


        for ($i = 0; $i < 10; $i++) {
            $user = User::factory(1)->create();
            $type = Type::factory(1)->create([
                'creator_id' => $user->first()->id,
            ]);
            Task::factory(5)->create([
                'creator_id' => $user->first()->id,
                'type_id' => $type->first()->id,
            ]);

            Task::factory(5)->create([
                'creator_id' => $user->first()->id,
                'type_id' => Type::factory(),
            ]);
        }

    }
}
