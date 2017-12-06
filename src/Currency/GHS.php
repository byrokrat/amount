<?php

declare(strict_types = 1);

namespace byrokrat\amount\Currency;

/**
 * The Ghanaian Cedi currency
 *
 * This file has ben auto generated and should not be edited directly
 */
class GHS extends \byrokrat\amount\Currency
{
    public function getCurrencyCode(): string
    {
        return 'GHS';
    }

    public static function getDisplayPrecision(): int
    {
        return 2;
    }
}
