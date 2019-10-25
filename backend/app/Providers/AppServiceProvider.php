<?php

namespace App\Providers;

use App\Providers\Repositories\BaseRepositoryServiceProvider;
use App\Providers\Utils\UtilsServiceProvider;
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
        $this->app->register(BaseRepositoryServiceProvider::class);
        $this->app->register(UtilsServiceProvider::class);
    }
}
