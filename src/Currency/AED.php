<?php

declare(strict_types = 1);

namespace byrokrat\amount\Currency;

/**
 * The UAE Dirham currency
 *
 * This file has ben auto generated and should not be edited directly
 */
class AED extends \byrokrat\amount\Currency
{
    public function getCurrencyCode(): string
    {
        return 'AED';
    }

    public static function getDisplayPrecision(): int
    {
        return 2;
    }
}
