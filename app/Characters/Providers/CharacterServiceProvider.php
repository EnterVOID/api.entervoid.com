<?php

namespace App\Characters\Providers;

use Illuminate\Support\ServiceProvider;

class CharacterServiceProvider extends ServiceProvider
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
                'prefix' => 'characters',
                'namespace' => 'App\Characters\Http\Controllers',
            ],
            function ($app) {
                require __DIR__ . '/../Http/routes.php';
            }
        );
    }
}
