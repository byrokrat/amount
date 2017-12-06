<?php

declare(strict_types = 1);

namespace byrokrat\amount\Currency;

/**
 * The Moldovan Leu currency
 *
 * This file has ben auto generated and should not be edited directly
 */
class MDL extends \byrokrat\amount\Currency
{
    public function getCurrencyCode(): string
    {
        return 'MDL';
    }

    public static function getDisplayPrecision(): int
    {
        return 2;
    }
}
