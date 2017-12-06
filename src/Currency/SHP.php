<?php

declare(strict_types = 1);

namespace byrokrat\amount\Currency;

/**
 * The Saint Helena Pound currency
 *
 * This file has ben auto generated and should not be edited directly
 */
class SHP extends \byrokrat\amount\Currency
{
    public function getCurrencyCode(): string
    {
        return 'SHP';
    }

    public static function getDisplayPrecision(): int
    {
        return 2;
    }
}
