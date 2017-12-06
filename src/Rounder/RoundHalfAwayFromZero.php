<?php

declare(strict_types = 1);

namespace byrokrat\amount\Rounder;

/**
 * Round to nearest and break ties by rounding half-way values away from zero
 */
class RoundHalfAwayFromZero implements \byrokrat\amount\Rounder
{
    use ToolkitConsumer;

    public function round(string $value, int $precision): string
    {
        return $this->toolkit->roundToNearest($value, $precision, function ($value, $precision) {
            return $this->toolkit->roundAwayFromZero($value, $precision);
        });
    }
}
