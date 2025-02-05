<?php

namespace App\Domains\Tasks\Database\Seeders;

use App\Domains\Tasks\Database\Models\Type;
use Illuminate\Database\Seeder;

class TypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Type::factory(10)->create();
    }
}
