<?php

namespace App\Providers;

use App\Services\Provider\IProviderManager;
use App\Services\Provider\ProviderManager;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(IProviderManager::class, function ($app) {
            return new ProviderManager($app);
        });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
