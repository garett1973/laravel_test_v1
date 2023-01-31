<?php

namespace App\Providers;

use App\Models\Users\Repositories\Interfaces\UserRepositoryInterface;
use App\Models\Users\Repositories\UserRepository;
use App\Models\Users\Services\Interfaces\UserServiceInterface;
use App\Models\Users\Services\UserService;
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
        $this->app->bind(
            UserServiceInterface::class,
            UserService::class
        );

        $this->app->bind(
            UserRepositoryInterface::class,
            UserRepository::class
        );
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
