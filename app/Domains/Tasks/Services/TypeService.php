<?php

namespace App\Domains\Tasks\Services;

use App\Domains\Tasks\Repositories\TypeRepository;

class TypeService
{
    protected TypeRepository $typeRepository;

    public function __construct(TypeRepository $typeRepository)
    {
        $this->typeRepository = $typeRepository;
    }

    public function getSmallListOfTypes(int $limit, string $search): array
    {

        if (!$search.emptyString()) {
            return $this->typeRepository->getTypesBySearch($limit, $search);
        }
    }


}
