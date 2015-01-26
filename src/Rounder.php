<?php

namespace byrokrat\amount;

/**
 * Defines a rounding strategy
 */
interface Rounder
{
    /**
     * Round $value to $precision number of decimal digits
     *
     * @param  string  $value
     * @param  integer $precision
     * @return string
     */
    public function round($value, $precision);
}
