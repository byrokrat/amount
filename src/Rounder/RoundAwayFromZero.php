<?php

namespace byrokrat\amount\Rounder;

/**
 * Round away from zero
 */
class RoundAwayFromZero implements \byrokrat\amount\Rounder
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
        return $this->toolkit->roundAwayFromZero($value, $precision);
    }
}
