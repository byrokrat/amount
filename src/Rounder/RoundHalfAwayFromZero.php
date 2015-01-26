<?php

namespace byrokrat\amount\Rounder;

/**
 * Round to nearest and break ties by rounding half-way values away from zero
 */
class RoundHalfAwayFromZero implements \byrokrat\amount\Rounder
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
            return $this->toolkit->roundAwayFromZero($value, $precision);
        });
    }
}
