<?php

declare(strict_types = 1);

namespace byrokrat\amount\Currency;

/**
 * The Romanian Leu currency
 *
 * This file has ben auto generated and should not be edited directly
 */
class RON extends \byrokrat\amount\Currency
{
    public function getCurrencyCode(): string
    {
        return 'RON';
    }

    public static function getDisplayPrecision(): int
    {
        return 2;
    }
}
