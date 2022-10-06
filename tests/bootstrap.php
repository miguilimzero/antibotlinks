<?php

require __DIR__ . '/../vendor/autoload.php';

use Illuminate\Container\Container as Container;
use Illuminate\Support\Facades\Facade as Facade;

$app = new Container();
$app->singleton('app', 'Illuminate\Container\Container');

// setup cache
$app->singleton('cache', function ($app) {
    return new Illuminate\Cache\Repository(
        new Illuminate\Cache\FileStore(new Illuminate\Filesystem\Filesystem(), __DIR__ . '/cache')
    );
});

/**
* Set $app as FacadeApplication handler
*/
Facade::setFacadeApplication($app);
