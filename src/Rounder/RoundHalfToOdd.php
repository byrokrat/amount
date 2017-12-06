<?php

declare(strict_types = 1);

namespace byrokrat\amount\Rounder;

/**
 * Round to nearest and break ties by rounding half-way values to nearest odd value
 */
class RoundHalfToOdd implements \byrokrat\amount\Rounder
{
    use ToolkitConsumer;

    public function round(string $value, int $precision): string
    {
        return $this->toolkit->roundToNearest($value, $precision, function ($value, $precision) {
            $up = $this->toolkit->roundUp($value, $precision);

            if (!$this->toolkit->isEven(substr($up, -1))) {
                return $up;
            }

            return $this->toolkit->roundDown($value, $precision);
        });
    }
}
