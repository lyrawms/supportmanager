<?php

namespace App\Domains\Tasks\Repositories;

use App\Models\Task;
use Illuminate\Pagination\LengthAwarePaginator;

class TaskRepository
{
public function getAll(): LengthAwarePaginator
{
    return Task::paginate(10);
}


}
