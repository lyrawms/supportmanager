<?php

namespace App\Domains\Tasks\Repositories;

use App\Domains\Tasks\Database\Models\Type;
use Illuminate\Database\Eloquent\Collection;

class TypeRepository
{

    public function getTypesBySearch(string $string)
    {
        return Type::where('title', 'like', '%' . $string . '%')
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
}
