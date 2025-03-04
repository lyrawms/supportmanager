<?php

namespace App\Domains\Tasks\Controllers;

use App\Domains\Tasks\Services\TypeService;
use Illuminate\Http\Request;

class SaveTypeController
{
    public function __invoke(Request $request)
    {
        $validatedData = $request->validate([
            'title' => 'required|string|unique:types,title',
            'color' => 'required|hex_color|unique:types,color',
        ]);

        $typeService = new TypeService();

        return response()->json([
            'uuid' => $typeService->saveType($validatedData),
        ]);
    }
}
