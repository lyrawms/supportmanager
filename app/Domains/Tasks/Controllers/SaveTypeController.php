<?php

namespace App\Domains\Tasks\Controllers;

use App\Domains\Tasks\Services\TypeService;
use Illuminate\Http\Request;

class SaveTypeController
{
    public function __invoke(Request $request, TypeService $typeService)
    {
        $validatedData = $request->validate([
            'title' => 'required|string|unique:types,title',
            'sla' => 'required|integer',
            'color' => 'required|hex_color|unique:types,color',
        ]);

        $typeService->saveType($validatedData);

        return redirect(route('settings'));



    }
}
