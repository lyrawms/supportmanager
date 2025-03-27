<?php

namespace App\Domains\Users\Services;

use App\Domains\Users\Repositories\UserRepository;
use Illuminate\Database\Eloquent\Collection;

class UserService
{
    protected UserRepository $userRepository;
    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function getSmallListOfUsers(?string $query, ?string $currentAssignedUser): Collection
    {
        // If the query is not empty, return the users that match the query, otherwise return the default users
        if (!empty($query)) {
            return $this->userRepository->getUsersBySearch($query, $currentAssignedUser);
        } else {
            return $this->userRepository->getSmallListOfUsers($currentAssignedUser);
        }
    }
}
