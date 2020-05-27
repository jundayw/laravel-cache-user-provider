<?php

namespace Jundayw\LaravelCacheUserProvider;

use Jundayw\LaravelCacheUserProvider\CacheUserProvider;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\ServiceProvider;

class CacheUserProviderServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Auth::provider('cache', function($app, $config) {
            return new CacheUserProvider($app['hash'], $config['model']);
        });
    }
}
