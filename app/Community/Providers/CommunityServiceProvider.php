<?php

namespace App\Community\Providers;

use Illuminate\Support\ServiceProvider;

class CommunityServiceProvider extends ServiceProvider
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
                'prefix' => 'webpages',
                'namespace' => 'App\Community\Http\Controllers',
            ],
            function ($app) {
                require __DIR__ . '/../Http/webpage_routes.php';
            }
        );
        /** @noinspection PhpUndefinedMethodInspection */
        $this->app->group(
            [
                'prefix' => 'comments',
                'namespace' => 'App\Community\Http\Controllers',
            ],
            function ($app) {
                require __DIR__ . '/../Http/comment_routes.php';
            }
        );
    }
}
