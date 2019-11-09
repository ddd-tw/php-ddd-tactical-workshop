<?php

declare(strict_types=1);

namespace App\Providers;

use App\Mongo\MongoSrv;
use Illuminate\Support\ServiceProvider;

class MongoServiceProvider extends ServiceProvider
{
    protected $defer = true;

    public function register()
    {
        $this->app->singleton('mongo', function($app) {

            $config = $app->make('config');
            $uri = $config->get('services.mongo.uri');

            return new MongoSrv($uri, [], []);
        });
    }

    public function provides()
    {
        return ['mongo'];
    }
}