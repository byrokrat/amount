<?php

declare(strict_types = 1);

namespace byrokrat\amount\Currency;

/**
 * The Tanzanian Shilling currency
 *
 * This file has ben auto generated and should not be edited directly
 */
class TZS extends \byrokrat\amount\Currency
{
    public function getCurrencyCode(): string
    {
        return 'TZS';
    }

    public static function getDisplayPrecision(): int
    {
        return 2;
    }
}
