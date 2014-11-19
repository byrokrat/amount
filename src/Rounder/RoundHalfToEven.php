<?php
/**
 * This program is free software. It comes without any warranty, to
 * the extent permitted by applicable law. You can redistribute it
 * and/or modify it under the terms of the Do What The Fuck You Want
 * To Public License, Version 2, as published by Sam Hocevar. See
 * http://www.wtfpl.net/ for more details.
 */

namespace ledgr\amount\Rounder;

/**
 * Round to nearest and break ties by rounding half-way values to nearest even value
 *
 * @author Hannes Forsgård <hannes.forsgard@fripost.org>
 */
class RoundHalfToEven implements \ledgr\amount\Rounder
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
