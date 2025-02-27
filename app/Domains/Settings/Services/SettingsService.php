<?php

namespace App\Domains\Settings\Services;

use App\Domains\Tasks\Repositories\TypeRepository;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

class SettingsService
{

    protected TypeRepository $typeRepository;
    public function __construct()
    {
    }


}
