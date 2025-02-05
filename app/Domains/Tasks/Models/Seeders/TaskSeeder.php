<?php

namespace App\Domains\Tasks\Models\Seeders;

use App\Domains\Tasks\Models\Task;
use Illuminate\Database\Seeder;

class TaskSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Task::factory()->count(50)->create();
    }
}
