<?php

declare(strict_types = 1);

namespace byrokrat\amount\Currency;

/**
 * The Pakistani Rupee currency
 *
 * This file has ben auto generated and should not be edited directly
 */
class PKR extends \byrokrat\amount\Currency
{
    public function getCurrencyCode(): string
    {
        return 'PKR';
    }

    public static function getDisplayPrecision(): int
    {
        return 2;
    }
}
