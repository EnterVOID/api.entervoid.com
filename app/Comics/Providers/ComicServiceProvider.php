<?php

namespace App\Comics\Providers;

use Illuminate\Support\ServiceProvider;

class ComicServiceProvider extends ServiceProvider
{
    public function register()
    {
        // TODO: Implement register() method.
    }

    public function boot()
    {
        /** @noinspection PhpUndefinedMethodInspection */
        $this->app->group(
            [
                'prefix' => 'comics',
                'namespace' => 'App\Comics\Http\Controllers',
            ],
            function ($app) {
                require __DIR__ . '/../Http/comic_routes.php';
            }
        );
        /** @noinspection PhpUndefinedMethodInspection */
        $this->app->group(
            [
                'prefix' => 'matches',
                'namespace' => 'App\Comics\Http\Controllers',
            ],
            function ($app) {
                require __DIR__ . '/../Http/match_routes.php';
            }
        );
    }
}
