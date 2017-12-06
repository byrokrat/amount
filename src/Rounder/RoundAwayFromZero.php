<?php

declare(strict_types = 1);

namespace byrokrat\amount\Rounder;

/**
 * Round away from zero
 */
class RoundAwayFromZero implements \byrokrat\amount\Rounder
{
    use ToolkitConsumer;

    public function round(string $value, int $precision): string
    {
        return $this->toolkit->roundAwayFromZero($value, $precision);
    }
}
