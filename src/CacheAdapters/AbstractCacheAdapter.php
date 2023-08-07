<?php

namespace Miguilim\AntiBotLinks\CacheAdapters;

abstract class AbstractCacheAdapter
{
    abstract public function remember(string $key, int $expiresIn, callable $callback): mixed;

    abstract public function get(string $key): mixed;

    abstract public function forget(string $key): bool;
}