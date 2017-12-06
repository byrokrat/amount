<?php

declare(strict_types = 1);

namespace byrokrat\amount\Currency;

/**
 * The Swiss Franc currency
 *
 * This file has ben auto generated and should not be edited directly
 */
class CHF extends \byrokrat\amount\Currency
{
    public function getCurrencyCode(): string
    {
        return 'CHF';
    }

    public static function getDisplayPrecision(): int
    {
        return 2;
    }
}
