<?php

namespace Database\Seeders;

use App\Domains\Tasks\Database\Seeders\TaskSeeder;
use App\Domains\Tasks\Database\Seeders\TypeSeeder;
use App\Domains\Users\Database\Seeders\UserSeeder;
use Illuminate\Database\Seeder;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            UserSeeder::class,
            TypeSeeder::class,
            TaskSeeder::class,
        ]);
    }
}
