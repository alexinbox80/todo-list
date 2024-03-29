<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Services\Contracts\ResponseContract;
use App\Services\Response\ResponseService;
use App\Services\Contracts\TaskContract;
use App\Services\Task\TaskService;
use App\Services\Contracts\EventContract;
use App\Services\Event\EventService;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(ResponseContract::class, ResponseService::class);
        $this->app->bind(TaskContract::class, TaskService::class);
        $this->app->bind(EventContract::class, EventService::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
