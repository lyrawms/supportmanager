<?php

namespace App\Domains\Users\Repositories;

use App\Domains\Users\Database\Models\User;
use Illuminate\Database\Eloquent\Collection;

class UserRepository
{
    public function getUsersBySearch(string $string, string $currentAssignedUser): Collection
    {
        return User::where('name', 'like', '%' . $string . '%')
            ->where('uuid', '!=', $currentAssignedUser)
            ->orderBy('name', 'asc')
            ->limit(5)
            ->get();
    }

    public function getSmallListOfUsers(string $currentAssignedUser): Collection
    {
        return User::where('uuid', '!=', $currentAssignedUser)
            ->orderBy('name', 'asc')
            ->limit(5)
            ->get();
    }
}
