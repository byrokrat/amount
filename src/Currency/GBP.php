<?php

declare(strict_types = 1);

namespace byrokrat\amount\Currency;

/**
 * The Pound Sterling currency
 *
 * This file has ben auto generated and should not be edited directly
 */
class GBP extends \byrokrat\amount\Currency
{
    public function getCurrencyCode(): string
    {
        return 'GBP';
    }

    public static function getDisplayPrecision(): int
    {
        return 2;
    }
}
