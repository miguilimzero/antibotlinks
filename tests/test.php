<?php

require __DIR__ . '/../vendor/autoload.php';

use Miguilim\AntiBotLinks\AntiBotLinks;
use Miguilim\AntiBotLinks\CacheAdapters\SimpleFileCacheAdapter;

$antiBotLinks = AntiBotLinks::make('1', new SimpleFileCacheAdapter(__DIR__ . '/cache'), 60);

var_dump($antiBotLinks->generateLinks());
