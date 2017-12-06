<?php

declare(strict_types = 1);

namespace byrokrat\amount\Rounder;

/**
 * Rounding helper methods
 */
class Toolkit
{
    /**
     * Check if value is positive
     */
    public function isPositive(string $value): bool
    {
        return 1 == bccomp($value, '0', $this->parsePrecision($value));
    }

    /**
     * Check if value is even
     */
    public function isEven(string $value): bool
    {
        return 0 == bcmod($value, '2');
    }

    /**
     * Extract the precision used in $value
     */
    public function parsePrecision(string $value): int
    {
        if (strpos($value, '.') === false) {
            return 0;
        }

        list(, $fraction) = explode('.', $value);

        return strlen(rtrim($fraction, '0'));
    }

    /**
     * Get one unit in the scale of $precision
     */
    public function getOneUnit(int $precision): string
    {
        return bcdiv(
            '1',
            '1' . str_repeat('0', $precision),
            $precision
        );
    }

    /**
     * Round value towards zero
     */
    public function roundTowardsZero(string $value, int $precision): string
    {
        return bcadd($value, '0', $precision);
    }

    /**
     * Round value away from zero
     */
    public function roundAwayFromZero(string $value, int $precision): string
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
     */
    public function roundUp(string $value, int $precision): string
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
     */
    public function roundDown(string $value, int $precision): string
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
     */
    public function getTiebreak(string $value, int $precision): string
    {
        return $this->roundTowardsZero($value, $precision) . ($precision > 0 ? '5' : '.5');
    }

    /**
     * Round to nearest using callback for breaking ties
     */
    public function roundToNearest(string $value, int $precision, callable $tiebreakCallback): string
    {
        if ($this->parsePrecision($value) <= $precision) {
            return $value;
        }

        switch (bccomp($value, $this->getTiebreak($value, $precision), $precision + 1)) {
            case 1:
                return $this->roundUp($value, $precision);
            case -1:
                return $this->roundDown($value, $precision);
            default:
                return $tiebreakCallback($value, $precision);
        }
    }
}
