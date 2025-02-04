<?php

namespace App\Domains\Tasks\Repositories;

use App\Models\Task;
use Illuminate\Support\Collection;

class TaskRepository
{
public function getAll(): Collection
{
    return Task::all();
}
}
