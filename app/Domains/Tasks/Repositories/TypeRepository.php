<?php

namespace App\Domains\Tasks\Repositories;

use App\Domains\Tasks\Database\Models\Type;

class TypeRepository
{

    public function getTypesBySearch(string $string) {
        return Type::where('title', 'like', '%' . $string . '%')
            ->orderBy('title', 'asc')
            ->limit(5)
            ->get();
    }

    public function getSmallListOfTypes() {
        return Type::orderBy('title', 'asc')
            ->limit(5)
            ->get();
    }
}
