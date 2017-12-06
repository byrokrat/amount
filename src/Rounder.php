<?php

namespace byrokrat\amount;

/**
 * Defines a rounding strategy
 */
interface Rounder
{
    /**
     * Round $value to $precision number of decimal digits
     */
    public function round(string $value, int $precision): string;
}
