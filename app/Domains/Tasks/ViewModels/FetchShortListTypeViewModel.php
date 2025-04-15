<?php

namespace App\Domains\Tasks\ViewModels;

use App\Domains\Tasks\Services\TypeService;
use App\Http\ViewModels\ViewModel;

class FetchShortListTypeViewModel extends ViewModel
{

    protected TypeService $typeService;
    public function __construct(TypeService $typeService)
    {
        $this->typeService = $typeService;
    }


    public function toArray($query = null, $currentAssignedType = null): array
    {
        return [
            'types' => $this->typeService->getSmallListOfTypes($query, $currentAssignedType)->toArray(),
        ];
    }
}
