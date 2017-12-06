<?php

declare(strict_types = 1);

namespace byrokrat\amount\Currency;

/**
 * The Polish Zloty currency
 *
 * This file has ben auto generated and should not be edited directly
 */
class PLN extends \byrokrat\amount\Currency
{
    public function getCurrencyCode(): string
    {
        return 'PLN';
    }

    public static function getDisplayPrecision(): int
    {
        return 2;
    }
}
