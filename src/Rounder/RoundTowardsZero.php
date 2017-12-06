<?php

declare(strict_types = 1);

namespace byrokrat\amount\Rounder;

/**
 * Round towards zero
 */
class RoundTowardsZero implements \byrokrat\amount\Rounder
{
    use ToolkitConsumer;

    public function round(string $value, int $precision): string
    {
        return $this->toolkit->roundTowardsZero($value, $precision);
    }
}
