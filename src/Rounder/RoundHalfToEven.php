<?php

namespace byrokrat\amount\Rounder;

/**
 * Round to nearest and break ties by rounding half-way values to nearest even value
 */
class RoundHalfToEven implements \byrokrat\amount\Rounder
{
    use ToolkitConsumer;

    /**
     * Round $value to $precision number of decimal digits
     *
     * @param  string  $value
     * @param  integer $precision
     * @return string
     */
    public function round($value, $precision)
    {
        return $this->toolkit->roundToNearest($value, $precision, function ($value, $precision) {
            $up = $this->toolkit->roundUp($value, $precision);

            if ($this->toolkit->isEven(substr($up, -1))) {
                return $up;
            }

            return $this->toolkit->roundDown($value, $precision);
        });
    }
}
