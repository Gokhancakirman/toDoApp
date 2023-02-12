<?php

namespace App\Task;

use App\Models\Providers;

class Task
{
    const WEEKLY_WORK_HOUR = 45;
    public function assignTasks($tasks)
    {
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

        return ["tasks" => $weekly_schedule, "total_duration" => $total_duration];
    }
}
