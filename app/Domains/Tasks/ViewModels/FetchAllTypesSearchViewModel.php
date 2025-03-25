<?php

namespace App\Domains\Tasks\ViewModels;

use App\Domains\Tasks\Services\TypeService;

class FetchAllTypesSearchViewModel
{
    protected TypeService $typeService;

    public function __construct()
    {
        $this->typeService = new TypeService;
    }


    public function toArray(string $query): array
    {
        return [
            'types' => $this->typeService->fetchAllTypesSearch($query)->toArray(),
        ];
    }
}
