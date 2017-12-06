<?php

declare(strict_types = 1);

namespace byrokrat\amount\Currency;

/**
 * The Sri Lankan Rupee currency
 *
 * This file has ben auto generated and should not be edited directly
 */
class LKR extends \byrokrat\amount\Currency
{
    public function getCurrencyCode(): string
    {
        return 'LKR';
    }

    public static function getDisplayPrecision(): int
    {
        return 2;
    }
}
