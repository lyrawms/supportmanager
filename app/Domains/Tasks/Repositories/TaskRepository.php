<?php

namespace App\Domains\Tasks\Repositories;

use App\Domains\Tasks\Database\Models\Task;
use Illuminate\Pagination\LengthAwarePaginator;

class TaskRepository
{
    public function getAll(): LengthAwarePaginator
    {
        return Task::orderBy('deadline', 'asc')
            ->orderBy('created_at', 'desc')
            ->paginate(10);
    }
}
