<?php

declare(strict_types = 1);

namespace byrokrat\amount\Currency;

/**
 * The Iranian Rial currency
 *
 * This file has ben auto generated and should not be edited directly
 */
class IRR extends \byrokrat\amount\Currency
{
    public function getCurrencyCode(): string
    {
        return 'IRR';
    }

    public static function getDisplayPrecision(): int
    {
        return 2;
    }
}
