<?php

namespace App\Domains\Tasks\ViewModels;

use App\Domains\Tasks\Services\TypeService;
use App\Http\ViewModels\ViewModel;

class IndexSearchTypeViewModel extends ViewModel
{
//    public string $component = 'Tasks/Components/ComboBox';

    protected TypeService $typeService;
    public function __construct()
    {
        $this->typeService = new TypeService;
    }


    public function toArray($query = null, $currentAssignedType = null): array
    {
        return [
            'types' => $this->typeService->getSmallListOfTypes($query, $currentAssignedType)->toArray(),
        ];
    }
}
