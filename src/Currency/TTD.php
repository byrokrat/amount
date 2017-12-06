<?php

declare(strict_types = 1);

namespace byrokrat\amount\Currency;

/**
 * The Trinidad and Tobago Dollar currency
 *
 * This file has ben auto generated and should not be edited directly
 */
class TTD extends \byrokrat\amount\Currency
{
    public function getCurrencyCode(): string
    {
        return 'TTD';
    }

    public static function getDisplayPrecision(): int
    {
        return 2;
    }
}
