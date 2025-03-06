<?php

namespace App\Domains\Tasks\Repositories;

use App\Domains\Tasks\Database\Models\Type;
use App\Domains\Users\Database\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

class TypeRepository
{

    public function getSmallListOfTypesBySearch(string $query, string $currentAssignedType): Collection
    {
        return Type::where('title', 'like', '%' . $query . '%')
            ->where('uuid', '!=', $currentAssignedType)
            ->orderBy('title', 'asc')
            ->limit(5)
            ->get();
    }
    public function getSmallListOfTypes(string $currentAssignedType): Collection
    {
        return Type::where('uuid', '!=', $currentAssignedType)
            ->orderBy('title', 'asc')
            ->limit(5)
            ->get();
    }
    public function getAllTypesSearch(string $query): Collection
    {
        return Type::where('title', 'like', '%' . $query . '%')
            ->orderBy('title', 'asc')
            ->limit(50)
            ->get();
    }


    public function getAllTypes(): LengthAwarePaginator
    {
        return Type::orderBy('color', 'desc')->paginate(50);
    }

    public function saveType(array $typeData, User $creator): string
    {
        $type = new Type();
        $type->title = $typeData['title'];
        $type->sla = $typeData['sla'];
        $type->color = $typeData['color'];
        $type->creator()->associate($creator);
        $type->save();

        return $type->uuid;
    }
}
