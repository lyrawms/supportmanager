<?php

namespace App\Domains\Tasks\Services;

use App\Domains\Tasks\Repositories\TypeRepository;
use App\Domains\Users\Database\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use PhpParser\Node\Expr\Cast\Object_;

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
            return $this->typeRepository->getSmallListOfTypesBySearch($query, $currentAssignedType);
        } else {
            return $this->typeRepository->getSmallListOfTypes($currentAssignedType);
        }
    }

    public function fetchAllTypesSearch(string $query = null): LengthAwarePaginator | \Illuminate\Support\Collection
    {
        if (!empty($query)) {
            return collect([
                'data' => $this->typeRepository->getAllTypesSearch($query)
            ]);
        } else {
            return $this->typeRepository->getAllTypes();
        }
    }

    public function saveType(array $typeData): string
    {
        $creator = User::findOrFail(auth()->id());

        return $this->typeRepository->saveType($typeData, $creator);
    }


}
