<?php

namespace App\Domains\Tasks\Controllers;

use App\Domains\Tasks\Services\TypeService;

class FetchTypeController
{

    protected $typeService;

    public function __construct(TypeService $typeService)
    {
        $this->typeService = $typeService;
    }
    public function __invoke()
    {
        return response()->json($this->typeService->getSmallListOfTypes(
            request()->query('limit',5),
            request()->query('search'),
        ));
    }

}
