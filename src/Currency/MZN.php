<?php

declare(strict_types = 1);

namespace byrokrat\amount\Currency;

/**
 * The Mozambican Metical currency
 *
 * This file has ben auto generated and should not be edited directly
 */
class MZN extends \byrokrat\amount\Currency
{
    public function getCurrencyCode(): string
    {
        return 'MZN';
    }

    public static function getDisplayPrecision(): int
    {
        return 2;
    }
}
