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
        // If the query is not empty, return the types that match the query, otherwise return the default types
        if (!empty($query)) {
            return $this->typeRepository->getSmallListOfTypesBySearch($query, $currentAssignedType);
        } else {
            return $this->typeRepository->getSmallListOfTypes($currentAssignedType);
        }
    }

    public function fetchAllTypesSearch(string $query): \Illuminate\Support\Collection
    {
        // Returns the types that match the query limit to 50
        return collect(['data' => $this->typeRepository->getAllTypesSearch($query)]);
    }

    public function fetchAllTypes(): LengthAwarePaginator
    {
        // Returns all types paginated
        return $this->typeRepository->getAllTypes();
    }

    public function saveType(array $typeData): string
    {
        // fetch the creator
        $creator = User::findOrFail(auth()->id());

        // Save the type and return the uuid
        return $this->typeRepository->saveType($typeData, $creator);
    }


}
