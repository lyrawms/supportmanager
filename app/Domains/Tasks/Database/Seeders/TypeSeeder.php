<?php

namespace App\Domains\Tasks\Database\Seeders;

use App\Domains\Tasks\Database\Models\Type;
use App\Domains\Users\Database\Models\User;
use Illuminate\Database\Seeder;

class TypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::all()->each(function (User $user) {
            Type::factory(3)->create([
                'creator_id' => $user->id,
            ]);
        });

    }
}
