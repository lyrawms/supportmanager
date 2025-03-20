<?php

namespace App\Console\Commands;

use App\Domains\Tasks\Controllers\CheckDeadline1DayController;
use App\Domains\Tasks\Services\TaskService;
use Illuminate\Console\Command;

class TaskDeadline1DayCheck extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'task:deadline-1day-check';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check if there are tasks 1 day before the deadline, and send a slack notification to the support-manager channel';

    /**
     * Execute the console command.
     */
    public function handle(TaskService $taskService)
    {
        $controller = new CheckDeadline1DayController();
        $controller->__invoke($taskService);
        $this->info('task:deadline-1day-check command ran successfully');
    }
}
