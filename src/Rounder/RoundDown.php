<?php

declare(strict_types = 1);

namespace byrokrat\amount\Rounder;

/**
 * Round towards negative infinity
 */
class RoundDown implements \byrokrat\amount\Rounder
{
    use ToolkitConsumer;

    public function round(string $value, int $precision): string
    {
        return $this->toolkit->roundDown($value, $precision);
    }
}
