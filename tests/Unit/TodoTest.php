<?php

namespace Tests\Unit;

use App\Models\Developers;
use App\Services\Provider\ProviderManager;
use App\Services\Provider\ProviderService;
use Tests\TestCase;


class TodoTest extends TestCase
{
    const WEEKLY_WORK_HOUR = 45;
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function test_provider()
    {

        $providers = [
            [
                'name' => 'Provider1',
                'url' => 'http://www.mocky.io/v2/5d47f24c330000623fa3ebfa',
                'parameters' => 'id,zorluk,sure'
            ],
            [
                'name' => 'Provider2',
                'url' => 'http://www.mocky.io/v2/5d47f235330000623fa3ebf7',
                'parameters' => '{key},level,estimated_duration'
            ]
        ];

        foreach ($providers as $pr) {
            $provider = new ProviderService($pr['url'], $pr['name'], $pr['parameters']);
            $provider->getProviders();
        }

        $this->assertTrue(true);
    }

    public function test_assign()
    {
        $tasks = [
            [
                "name" => "IT Task 5",
                "difficulty" => 1,
                "duration" => 12
            ],
            [
                "name" => "IT Task 5",
                "difficulty" => 1,
                "duration" => 10
            ],
            [
                "name" => "IT Task 5",
                "difficulty" => 1,
                "duration" => 5
            ],
            [
                "name" => "IT Task 5",
                "difficulty" => 1,
                "duration" => 30
            ],
            [
                "name" => "IT Task 5",
                "difficulty" => 1,
                "duration" => 9
            ],
            [
                "name" => "IT Task 5",
                "difficulty" => 1,
                "duration" => 6
            ]
        ];

        $week = 0;
        $weekly_schedule = [];
        $total_duration = 0;

        // Check if the array of tasks is empty before looping
        if (!empty($tasks)) {
            while(true) {
                $weekly_hours = self::WEEKLY_WORK_HOUR ;
                $task_assigned = false;
                foreach ($tasks as $key => $task) {
                    if ($weekly_hours >= $task["duration"]) {
                        $weekly_hours -= $task["duration"];
                        $total_duration += $task["duration"];
                        $weekly_schedule[$week][] = $task;
                        unset($tasks[$key]);
                        $task_assigned = true;
                    }
                    else {
                        $duration = $weekly_hours;
                        $left_duration = $task["duration"] - $weekly_hours;
                        $task["duration"] = $duration;
                        $total_duration += $task["duration"];
                        $weekly_schedule[$week][] = $task;
                        $tasks[$key]["duration"] = $left_duration;
                        $task_assigned = true;
                        break;
                    }
                }
                // If no tasks were assigned in this iteration, break out of the loop
                if (!$task_assigned) {
                    break;
                }
                $week++;
            }
        }
        $this->assertNotEmpty($weekly_schedule);
    }
}
