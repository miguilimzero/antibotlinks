<?php

namespace Miguilim\AntiBotLinks\Traits;

trait HasHelpers
{
    /**
     * Mount directory path for links fonts.
     */
    protected function asset(string $path): string
    {
        return __DIR__ . '/../../assets/' . $path;
    }

    /*
     * Get random set of values from a shuffled with keys array.
     */
    protected function getRandomShuffled(array $array, int $amount): array
    {
        return array_slice($this->shuffleWithKeys($array), 0, $amount, true);
    }

    /**
     * Shuffle array without loosing keys.
     */
    protected function shuffleWithKeys(array $array): array
    {
        $keys = array_keys($array);

        shuffle($keys);

        $new = [];
        foreach ($keys as $key) {
            $new[$key] = $array[$key];
        }

        return $new;
    }
}
