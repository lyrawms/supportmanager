<?php

namespace App\Domains\Users\Repositories;

use App\Domains\Users\Database\Models\User;
use Illuminate\Database\Eloquent\Collection;

class UserRepository
{
    public function getUsersBySearch(string $string, string $currentAssignedUser): Collection
    {
        // fetch a maximum of 5 users that match the search string, excluding the current assigned user
        return User::where('name', 'like', '%' . $string . '%')
            ->where('uuid', '!=', $currentAssignedUser)
            ->orderBy('name', 'asc')
            ->limit(5)
            ->get();
    }

    public function getSmallListOfUsers(string $currentAssignedUser): Collection
    {
        // fetch a maximum of 5 users excluding the current assigned user
        return User::where('uuid', '!=', $currentAssignedUser)
            ->orderBy('name', 'asc')
            ->limit(5)
            ->get();
    }

    public function updateSlackId(User $user, string $slackId): User
    {
        // update the user's slack id
        $user->slack_id = $slackId;
        $user->save();
        return $user->refresh();
    }
}
