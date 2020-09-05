<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;

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
            \App\Contracts\Repositories\UserRepository::class,
            \App\Repositories\UserRepository::class
        );
        $this->app->bind(
            \App\Contracts\Repositories\EntryRepository::class,
            \App\Repositories\EntryRepository::class
        );
        $this->app->bind(
            \App\Contracts\Repositories\CategoryRepository::class,
            \App\Repositories\CategoryRepository::class
        );
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Schema::defaultStringLength(191);
    }
}
