<?php

namespace App\Console\Commands;

use App\Domains\Tasks\Controllers\CheckDeadlineController;
use App\Domains\Tasks\Services\TaskService;
use Illuminate\Console\Command;

class TaskDeadlineCheck extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'task:deadline-check';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check if there are tasks outside the deadline, and send a slack notification to the support-manager channel';



    /**
     * Execute the console command.
     */
    public function handle(TaskService $taskService)
    {
        $controller = new CheckDeadlineController();
        $controller->__invoke($taskService);
        $this->info('task:deadline-check command ran successfully');
    }
}
