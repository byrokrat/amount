<?php

declare(strict_types = 1);

namespace byrokrat\amount\Currency;

/**
 * The Turkmenistani Manat currency
 *
 * This file has ben auto generated and should not be edited directly
 */
class TMT extends \byrokrat\amount\Currency
{
    public function getCurrencyCode(): string
    {
        return 'TMT';
    }

    public static function getDisplayPrecision(): int
    {
        return 2;
    }
}
