<?php

declare(strict_types = 1);

namespace byrokrat\amount\Currency;

/**
 * The Swedish Krona currency
 *
 * This file has ben auto generated and should not be edited directly
 */
class SEK extends \byrokrat\amount\Currency
{
    public function getCurrencyCode(): string
    {
        return 'SEK';
    }

    public static function getDisplayPrecision(): int
    {
        return 2;
    }
}
