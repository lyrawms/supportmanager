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

    public function getSmallListOfTypes(?string $search): Collection
    {
        if (!empty($search)) {
            return $this->typeRepository->getTypesBySearch($search);
        } else {
            return $this->typeRepository->getSmallListOfTypes();
        }
    }


}
