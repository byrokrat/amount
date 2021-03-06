<?php

declare(strict_types = 1);

namespace byrokrat\amount\Currency;

/**
 * The Israeli New Sheqel currency
 *
 * This file has ben auto generated and should not be edited directly
 */
class ILS extends \byrokrat\amount\Currency
{
    public function getCurrencyCode(): string
    {
        return 'ILS';
    }

    public static function getDisplayPrecision(): int
    {
        return 2;
    }
}
