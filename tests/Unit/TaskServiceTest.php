<?php

namespace Tests\Unit;

use App\Domains\Tasks\Services\TaskService;
use Carbon\Carbon;
use Exception;
use PHPUnit\Framework\TestCase;

class TaskServiceTest extends TestCase
{

    protected TaskService $taskService;

    public function setUp(): void
    {
        parent::setUp();
        $this->taskService = app(TaskService::class);
    }

    public function test_deadline_calculation_with_correct_data()
    {
        $typeSla = 5;
        $date = '2025-03-01 10:00:00';

        $calculatedDeadline = $this->taskService->calcDeadline($typeSla, $date);

        $expectedResult = '2025-03-06 10:00:00';
        $this->assertEquals($expectedResult, $calculatedDeadline);
    }

    public function test_deadline_calculation_with_negative_sla()
    {
        $typeSla = -5;
        $date = '2025-03-01 10:00:00';

        $this->expectException(Exception::class);
        $this->expectExceptionMessage('Sla must be a positive number');

        $this->taskService->calcDeadline($typeSla, $date);

    }

    public function test_deadline_calculation_with_invalid_date()
    {
        $typeSla = -5;
        $date = 'superinvaliddatetime';

        $this->expectException(Exception::class);
        $this->expectExceptionMessage('Date must be a valid datetime');


        $this->taskService->calcDeadline($typeSla, $date);

    }
}
