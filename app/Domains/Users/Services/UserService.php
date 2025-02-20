<?php

namespace App\Domains\Users\Services;

use App\Domains\Users\Repositories\UserRepository;
use Illuminate\Database\Eloquent\Collection;

class UserService
{
    protected UserRepository $userRepository;
    public function __construct()
    {
        $this->userRepository = new UserRepository;
    }

    public function getSmallListOfUsers(?string $query, ?string $currentAssignedUser): Collection
    {
        if (!empty($query)) {
            return $this->userRepository->getUsersBySearch($query, $currentAssignedUser);
        } else {
            return $this->userRepository->getSmallListOfUsers($currentAssignedUser);
        }
    }
}
