<?php

declare(strict_types = 1);

namespace byrokrat\amount\Currency;

/**
 * The Kuna currency
 *
 * This file has ben auto generated and should not be edited directly
 */
class HRK extends \byrokrat\amount\Currency
{
    public function getCurrencyCode(): string
    {
        return 'HRK';
    }

    public static function getDisplayPrecision(): int
    {
        return 2;
    }
}
