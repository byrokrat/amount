<?php

declare(strict_types = 1);

namespace byrokrat\amount\Rounder;

/**
 * Round towards positive infinity
 */
class RoundUp implements \byrokrat\amount\Rounder
{
    use ToolkitConsumer;

    public function round(string $value, int $precision): string
    {
        return $this->toolkit->roundUp($value, $precision);
    }
}
