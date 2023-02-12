<?php

namespace App\Providers;

use App\Task\Task;
use Illuminate\Support\ServiceProvider;

class TaskServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('task',function(){
            return new Task();
        });
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
