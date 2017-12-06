<?php

declare(strict_types = 1);

namespace byrokrat\amount\Currency;

/**
 * The Guyanese Dollar currency
 *
 * This file has ben auto generated and should not be edited directly
 */
class GYD extends \byrokrat\amount\Currency
{
    public function getCurrencyCode(): string
    {
        return 'GYD';
    }

    public static function getDisplayPrecision(): int
    {
        return 2;
    }
}
