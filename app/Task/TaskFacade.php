<?php

namespace App\Task;

use Illuminate\Support\Facades\Facade;

class TaskFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'task';
    }
}
