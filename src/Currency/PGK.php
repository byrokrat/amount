<?php

declare(strict_types = 1);

namespace byrokrat\amount\Currency;

/**
 * The Papua New Guinean Kina currency
 *
 * This file has ben auto generated and should not be edited directly
 */
class PGK extends \byrokrat\amount\Currency
{
    public function getCurrencyCode(): string
    {
        return 'PGK';
    }

    public static function getDisplayPrecision(): int
    {
        return 2;
    }
}
