<?php

<<<<<<<< HEAD:app/Domains/Teams/Database/Seeders/TeamSeeder.php
namespace App\Domains\Teams\Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
========
namespace App\Domains\Tasks\Models\Seeders;

use App\Domains\Tasks\Models\Task;
>>>>>>>> ui-improvement:app/Domains/Tasks/Models/Seeders/TaskSeeder.php
use Illuminate\Database\Seeder;

class TeamSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
<<<<<<<< HEAD:app/Domains/Teams/Database/Seeders/TeamSeeder.php
        //
========
        Task::factory()->count(50)->create();
>>>>>>>> ui-improvement:app/Domains/Tasks/Models/Seeders/TaskSeeder.php
    }
}
