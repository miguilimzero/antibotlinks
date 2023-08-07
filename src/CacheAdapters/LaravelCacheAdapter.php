<?php

namespace Miguilim\AntiBotLinks\CacheAdapters;

use Illuminate\Support\Facades\Cache;

class LaravelCacheAdapter extends AbstractCacheAdapter
{
    public function remember(string $key, int $expiresIn, callable $callback): mixed
    {
        return Cache::remember($key, $expiresIn, $callback);
    }

    public function get(string $key): mixed
    {
        return Cache::get($key);
    }

    public function forget(string $key): bool
    {
        return Cache::forget($key);
    }
}