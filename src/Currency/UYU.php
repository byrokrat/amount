<?php

declare(strict_types = 1);

namespace byrokrat\amount\Currency;

/**
 * The Uruguayan Peso currency
 *
 * This file has ben auto generated and should not be edited directly
 */
class UYU extends \byrokrat\amount\Currency
{
    public function getCurrencyCode(): string
    {
        return 'UYU';
    }

    public static function getDisplayPrecision(): int
    {
        return 2;
    }
}
