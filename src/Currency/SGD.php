<?php

declare(strict_types = 1);

namespace byrokrat\amount\Currency;

/**
 * The Singapore Dollar currency
 *
 * This file has ben auto generated and should not be edited directly
 */
class SGD extends \byrokrat\amount\Currency
{
    public function getCurrencyCode(): string
    {
        return 'SGD';
    }

    public static function getDisplayPrecision(): int
    {
        return 2;
    }
}
