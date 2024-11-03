<?php

namespace Miguilim\AntiBotLinks;

use Intervention\Image\Colors\Rgb\Color;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\Geometry\Factories\LineFactory;
use Intervention\Image\Typography\FontFactory;
use Miguilim\AntiBotLinks\CacheAdapters\AbstractCacheAdapter;

class AntiBotLinks
{
    use Traits\HasOptions;
    use Traits\HasHelpers;

    /**
     * Fonts file list.
     */
    protected array $fonts = [
        'Exo-Regular.otf',
        'GoodDog.otf',
        'Lobster_1.3.otf',
        'Rubik-Medium.ttf',
        'ShadowsIntoLightTwo-Regular.ttf',
        'SlimJim.ttf',
    ];

    /**
     * Identifier hash for caching.
     */
    protected string $identifierHash;

    /**
     * Scan font directory in order to list available fonts.
     */
    public function __construct(protected string $identifier, protected AbstractCacheAdapter $cacheAdapter, protected int $expiresIn)
    {
        $this->identifierHash = md5('antibotlinks.' . $this->identifier);
    }

    /**
     * Make new AntiBotLinks instance.
     */
    public static function make(string $identifier, AbstractCacheAdapter $cacheAdapter, int $expiresIn = 300): self
    {
        return new static($identifier, $cacheAdapter, $expiresIn);
    }

    /**
     * Generate links randomly with images.
     */
    public function generateLinks(int $amount = 4): array
    {
        return $this->cacheAdapter->remember($this->identifierHash, $this->expiresIn, function () use ($amount) {
            // Randomly get set of words and randomize it words order
            $words    = $this->wordUniverse[array_rand($this->wordUniverse)];
            $universe = $this->getRandomShuffled((array) $words, $amount);

            // 50% of chance to flip solution/answers
            if (random_int(0, 1)) {
                $universe = array_flip($universe);
            }

            // Generate images without any repeated
            $options = array_map(fn ($after) => [
                'id'    => random_int(1, 99999),
                'image' => $this->generateRandomImage($after),
            ], $universe);

            $optionsShuffled = $options;
            shuffle($optionsShuffled);

            return [
                'links' => [
                    'phrase' => $this->generateRandomImage(join(', ', array_keys($universe))),
                    'options' => $optionsShuffled, // IMPORTANT: Shuffle images order only after generate the phrase! (or shuffle with a different variable)
                ],
                'solution' => array_column($options, 'id'),
            ];
        })['links'];
    }

    /**
     * Flush generated links cache.
     */
    public function flushLinks(): bool
    {
        return $this->cacheAdapter->forget($this->identifierHash);
    }

    /**
     * Validate given AntiBotLinks answer.
     */
    public function validateAnswer(string $value): bool
    {
        $solution = $this->cacheAdapter->get($this->identifierHash)['solution'] ?? null;

        if (! $solution) {
            return false;
        }

        return join('', $solution) === trim($value);
    }

    /**
     * Generate random image from a word.
     */
    protected function generateRandomImage(string $word): array
    {
        $fontFile = $this->asset("fonts/{$this->fonts[array_rand($this->fonts)]}");
        $width     = (strlen($word) + 1) * ((strlen($word) >= 10) ? 12 : 14);
        $height    = 40;

        // Random Settings
        $angle       = ($width > 125) ? random_int(-2, 2) : random_int(-7, 7);
        $textColor   = $this->generateRandomColor(isShadowColor: false);
        $shadowColor = $this->generateRandomColor(isShadowColor: true);

        // Create blank canvas
        $manager = new ImageManager(new Driver());
        $image = $manager->create($width, $height);

        // Add link background
        // TODO: Reimplement backgrounds. Not working with current version of InterventionImage.
        // if ($this->background) {
        //     $image->fill($this->asset('backgrounds/bg-' . random_int(1, 3) . '-' . (($this->darkTheme) ? 'l' : 'd') . '.png'));
        //     // ->brightness(($this->darkTheme) ? mt_rand(5, 15) : mt_rand(55, 75));
        // }

        // Add link text
        $image->text($word, (int) ($width / 2), (int) ($height / 2) + 1, function (FontFactory $font) use ($angle, $fontFile, $shadowColor): void {
            $font->filename($fontFile);
            $font->angle($angle);
            $font->size(22);
            $font->align('center');
            $font->valign('middle');
            $font->color($shadowColor);
        })->text($word, (int) ($width / 2), (int) ($height / 2), function (FontFactory $font) use ($angle, $fontFile, $textColor): void {
            $font->filename($fontFile);
            $font->angle($angle);
            $font->size(22);
            $font->align('center');
            $font->valign('middle');
            $font->color($textColor);
        });

        // Add link noise
        if ($this->noise) {
            for ($i = 0; $i < round($width / random_int(16, 22) * 10); ++$i) {
                $x = random_int(1, $width  - 3);
                $y = random_int(1, $height - 3);

                $image->drawLine(function (LineFactory $line) use ($x, $y, $textColor) {
                    $line->from($x, $y);
                    $line->to($x + random_int(1, 2), $y + ((random_int(0, 1)) ? -1 : +1));
                    $line->color($textColor);
                });
            }
        }

        return [
            'width'  => $width,
            'base64' => $image->toJpeg()->toDataUri()
        ];
    }

    /**
     * Generate random rgb() color array.
     */
    protected function generateRandomColor(bool $isShadowColor = false): Color
    {
        // TODO: Reimplement 4th channel (rgba). Not working with current version of InterventionImage.

        if ($this->darkTheme) {
            return ($isShadowColor)
                ? new Color(random_int(1, 80), random_int(1, 80), random_int(1, 80))
                : new Color(random_int(214, 254), random_int(214, 254), random_int(214, 254));
        }

        return ($isShadowColor)
            ? new Color(random_int(174, 254), random_int(174, 254), random_int(174, 254))
            : new Color(random_int(1, 80), random_int(1, 80), random_int(1, 80));
    }
}
