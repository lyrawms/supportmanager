<?php

namespace App\Domains\Teams\Database\Seeders;

use App\Domains\Tasks\Database\Models\Task;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use Illuminate\Database\Seeder;

class TeamSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Task::factory()->count(50)->create();
    }
}
