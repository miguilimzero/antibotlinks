<?php

namespace Srdante\AntiBotLinks\Traits;

trait HasHelpers
{
    /**
     * Mount directory path for links fonts.
     */
    protected function asset(string $path): string
    {
        return __DIR__ . '/../../assets/' . $path;
    }
}
