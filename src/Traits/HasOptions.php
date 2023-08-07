<?php

namespace Miguilim\AntiBotLinks\Traits;

trait HasOptions
{
    /**
     * The words set that will be used by the system.
     */
    protected array $wordUniverse = [
        ['one' => '1', 'two' => '2', 'three' => '3', 'four' => '4', 'five' => '5', 'six' => '6', 'seven' => '7', 'eight' => '8', 'nine' => '9', 'ten' => '10'],
        ['1'   => 'one', '2' => 'two', '3' => 'three', '4' => 'four', '5' => 'five', '6' => 'six', '7' => 'seven', '8' => 'eight', '9' => 'nine', '10' => 'ten'],
        ['1'   => 'I', '2' => 'II', '3' => 'III', '4' => 'IV', '5' => 'V', '6' => 'VI', '7' => 'VII', '8' => 'VIII', '9' => 'IX', '10' => 'X'],
        ['2-1' => '1', '1+1' => '2', '1+2' => '3', '2+2' => '4', '3+2' => '5', '2+4' => '6', '3+4' => '7', '4+4' => '8', '1+8' => '9', '5+6' => '11'],
        ['1'   => '3-2', '2' => '8-6', '3' => '1+2', '4' => '3+1', '5' => '9-4', '6' => '3+3', '7' => '6+1', '8' => '2*4', '9' => '3+6', '10' => '2+8'],
        ['--x' => 'OOX', '-x-' => 'OXO', 'x--' => 'XOO', 'xx-' => 'XXO', '-xx' => 'OXX', 'x-x' => 'XOX', '---' => 'OOO', 'xxx' => 'XXX', 'x-x-' => 'XOXO', '-x-x' => 'OXOX'],
        ['--x' => '--+', '-x-' => '-+-', 'x--' => '+--', 'xx-' => '++-', '-xx' => '-++', 'x-x' => '+-+', '---' => '---', 'xxx' => '+++', 'x-x-' => '+-+-', '-x-x' => '-+-+'],
        ['--x' => 'oo+', '-x-' => 'o+o', 'x--' => '+oo', 'xx-' => '++o', '-xx' => 'o++', 'x-x' => '+o+', '---' => 'ooo', 'xxx' => '+++', 'x-x-' => '+o+o', '-x-x' => 'o+o+'],
        ['oox' => '--+', 'oxo' => '-+-', 'xoo' => '+--', 'xxo' => '++-', 'oxx' => '-++', 'xox' => '+-+', 'ooo' => '---', 'xxx' => '+++', 'xoxo' => '+-+-', 'oxox' => '-+-+'],
        ['zoo' => '200', 'ozo' => '020', 'ooz' => '002', 'soo' => '500', 'oso' => '050', 'oos' => '005', 'lol' => '101', 'sos' => '505', 'zoz' => '202', 'lll' => '111'],
    ];

    /**
     * Add noise to image.
     */
    protected bool $noise = false;

    /**
     * Add background to image.
     */
    protected bool $background = false;

    /**
     * Dark theme enabled.
     */
    protected bool $darkTheme = false;

    /**
     * Set noise setting.
     */
    public function noise(bool $value = true): self
    {
        $this->noise = $value;

        return $this;
    }

    /**
     * Set background setting.
     */
    public function background(bool $value = true): self
    {
        $this->background = $value;

        return $this;
    }

    /**
     * Set dark theme setting.
     */
    public function darkTheme(bool $value = true): self
    {
        $this->darkTheme = $value;

        return $this;
    }

    /**
     *  Set work universe setting.
     */
    public function wordUniverse(array $value): self
    {
        $this->wordUniverse = $value;

        return $this;
    }

    /**
     * Merge word universe with custom words.
     */
    public function mergeWordUniverse(array $wordUniverse): self
    {
        $this->wordUniverse = array_merge($this->wordUniverse, $wordUniverse);

        return $this;
    }
}
