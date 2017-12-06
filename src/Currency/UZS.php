<?php

declare(strict_types = 1);

namespace byrokrat\amount\Currency;

/**
 * The Uzbekistan Som currency
 *
 * This file has ben auto generated and should not be edited directly
 */
class UZS extends \byrokrat\amount\Currency
{
    public function getCurrencyCode(): string
    {
        return 'UZS';
    }

    public static function getDisplayPrecision(): int
    {
        return 2;
    }
}
