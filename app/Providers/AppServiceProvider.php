<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Services\PyrusApiService;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(PyrusApiService::class, function ($app) {
            return new PyrusApiService();
        });
    }
}
