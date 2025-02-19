<?php

namespace App\Domains\Tasks\Services;

use App\Domains\Tasks\Repositories\TypeRepository;
use Illuminate\Database\Eloquent\Collection;

class TypeService
{
    protected TypeRepository $typeRepository;

    public function __construct()
    {
        $this->typeRepository = new TypeRepository;
    }

    public function getSmallListOfTypes(?string $query, ?string $currentAssignedType): Collection
    {
        if (!empty($query)) {
            return $this->typeRepository->getTypesBySearch($query);
        } else {
            return $this->typeRepository->getSmallListOfTypes($currentAssignedType);
        }
    }


}
