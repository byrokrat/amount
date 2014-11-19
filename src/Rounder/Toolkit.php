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
 * Rounding helper methods
 *
 * @author Hannes Forsgård <hannes.forsgard@fripost.org>
 */
class Toolkit
{
    /**
     * Check if value is positive
     *
     * @param  string $value
     * @return bool
     */
    public function isPositive($value)
    {
        return 1 == bccomp($value, 0, $this->parsePrecision($value));
    }

    /**
     * Check if value is even
     *
     * @param  string $value
     * @return bool
     */
    public function isEven($value)
    {
        return 0 == bcmod($value, '2');
    }

    /**
     * Extract the precision used in $value
     *
     * @param  string  $value
     * @return integer
     */
    public function parsePrecision($value)
    {
        if (strpos($value, '.') === false) {
            return 0;
        }

        list(, $fraction) = explode('.', $value);

        return strlen(rtrim($fraction, '0'));
    }

    /**
     * Get one unit in the scale of $precision
     *
     * @param  integer $precision
     * @return string
     */
    public function getOneUnit($precision)
    {
        return bcdiv(
            '1',
            '1' . str_repeat('0', $precision),
            $precision
        );
    }

    /**
     * Round value towards zero
     *
     * @param  string  $value
     * @param  integer $precision
     * @return string
     */
    public function roundTowardsZero($value, $precision)
    {
        return bcadd($value, '0', $precision);
    }

    /**
     * Round value away from zero
     *
     * @param  string  $value
     * @param  integer $precision
     * @return string
     */
    public function roundAwayFromZero($value, $precision)
    {
        if ($this->parsePrecision($value) <= $precision) {
            return $value;
        }

        if ($this->isPositive($value)) {
            return $this->roundUp($value, $precision);
        }

        return $this->roundDown($value, $precision);
    }

    /**
     * Round up value
     *
     * @param  string  $value
     * @param  integer $precision
     * @return string
     */
    public function roundUp($value, $precision)
    {
        if ($this->parsePrecision($value) <= $precision) {
            return $value;
        }

        if ($this->isPositive($value)) {
            return bcadd(
                $this->roundTowardsZero($value, $precision),
                $this->getOneUnit($precision),
                $precision
            );
        }

        return $this->roundTowardsZero($value, $precision);
    }

    /**
     * Round down value
     *
     * @param  string  $value
     * @param  integer $precision
     * @return string
     */
    public function roundDown($value, $precision)
    {
        if ($this->parsePrecision($value) <= $precision) {
            return $value;
        }

        if ($this->isPositive($value)) {
            return $this->roundTowardsZero($value, $precision);
        }

        return bcsub(
            $this->roundTowardsZero($value, $precision),
            $this->getOneUnit($precision),
            $precision
        );
    }

    /**
     * Get tiebreak value for round to nearest strategies
     *
     * @param  string  $value
     * @param  integer $precision
     * @return string
     */
    public function getTiebreak($value, $precision)
    {
        return $this->roundTowardsZero($value, $precision) . ($precision > 0 ? '5' : '.5');
    }

    /**
     * Round to nearest using callback for breaking ties
     *
     * @param  string   $value
     * @param  integer  $precision
     * @param  callable $tiebreakCallback
     * @return string
     */
    public function roundToNearest($value, $precision, callable $tiebreakCallback)
    {
        if ($this->parsePrecision($value) <= $precision) {
            return $value;
        }

        switch (bccomp($value, $this->getTiebreak($value, $precision), $precision+1)) {
            case 1:
                return $this->roundUp($value, $precision);
            case -1:
                return $this->roundDown($value, $precision);
        }

        return $tiebreakCallback($value, $precision);
    }
}
