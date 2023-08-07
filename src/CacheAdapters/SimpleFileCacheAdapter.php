<?php

namespace Miguilim\AntiBotLinks\CacheAdapters;

class SimpleFileCacheAdapter extends AbstractCacheAdapter
{
    public function __construct(protected string $cacheDir)
    {
        if (! str_ends_with($this->cacheDir, '/')) {
            $this->cacheDir .= '/';
        }
    
        if (! is_dir($this->cacheDir)) {
            mkdir($this->cacheDir, 0755, true);
        }
    }

    public function remember(string $key, int $expiresIn, callable $callback): mixed
    {
        $cacheFilePath = $this->getCacheFilePath($key);

        if ($this->isCacheValid($cacheFilePath)) {
            return $this->readCache($cacheFilePath)['content'];
        }

        $value = $callback();
        $this->writeCache($cacheFilePath, $value, $expiresIn);

        return $value;
    }

    public function get(string $key): mixed
    {
        $cacheFilePath = $this->getCacheFilePath($key);

        if ($this->isCacheValid($cacheFilePath)) {
            return $this->readCache($cacheFilePath)['content'];
        }

        return null;
    }

    public function forget(string $key): bool
    {
        $cacheFilePath = $this->getCacheFilePath($key);

        if (file_exists($cacheFilePath)) {
            return unlink($cacheFilePath);
        }

        return false;
    }

    protected function getCacheFilePath(string $key): string 
    {
        return $this->cacheDir . '/' . md5($key) . '.cache';
    }

    protected function isCacheValid(string $cacheFilePath): bool 
    {
        if (file_exists($cacheFilePath)) {
            $expiresAt = (int) $this->readCache($cacheFilePath)['expires_at'];

            return $expiresAt > time();
        }

        return false;
    }

    protected function readCache(string $cacheFilePath): mixed 
    {
        return unserialize(file_get_contents($cacheFilePath));
    }

    protected function writeCache(string $cacheFilePath, mixed $value, int $expiresIn): void 
    {
        $expiresAt = time() + $expiresIn;

        file_put_contents($cacheFilePath, serialize(['expires_at' => $expiresAt, 'content' => $value]));
    }
}