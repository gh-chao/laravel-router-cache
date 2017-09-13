<?php

namespace Lilocon\RouterCache;

use Illuminate\Support\ServiceProvider;

class RouterCacheServiceProvider extends ServiceProvider
{
    /**
     * Perform post-registration booting of services.
     *
     * @return void
     */
    public function boot()
    {

    }

    /**
     * Register any package services.
     *
     * @return void
     */
    public function register()
    {
        app('router')->middlewareGroup('router.cache', []);

        if (false === config('app.debug')) {
            app('router')->setRoutes(new RouteCollection());
        }
    }
}