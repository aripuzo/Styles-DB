<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class RepositoryProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register(){
        //
        $this->app->bind(
                'App\Repository\Contracts\UserRepository', 'App\Repository\UserRepo'
        );
        $this->app->bind(
                'App\Repository\Contracts\ItemRepository', 'App\Repository\ItemRepo'
        );
        $this->app->bind(
                'App\Repository\Contracts\ItemPropertyRepository', 'App\Repository\ItemPropertyRepo'
        );
        $this->app->bind(
                'App\Repository\Contracts\StatRepository', 'App\Repository\StatRepo'
        );
        $this->app->bind(
                'App\Repository\Contracts\DesignerRepository', 'App\Repository\DesignerRepo'
        );
    }
}
