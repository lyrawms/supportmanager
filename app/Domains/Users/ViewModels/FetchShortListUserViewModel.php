<?php

namespace App\Domains\Users\ViewModels;

use App\Domains\Users\Services\UserService;
use App\Http\ViewModels\ViewModel;

class FetchShortListUserViewModel extends ViewModel
{
    protected UserService $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function toArray($query = null, $currentAssignedUser = null): array
    {
        return [
            'users' => $this->userService->getSmallListOfUsers($query, $currentAssignedUser)->toArray(),
        ];
    }
}
