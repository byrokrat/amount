<?php

namespace byrokrat\amount\Rounder;

/**
 * Round towards positive infinity
 */
class RoundUp implements \byrokrat\amount\Rounder
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
        return $this->toolkit->roundUp($value, $precision);
    }
}
