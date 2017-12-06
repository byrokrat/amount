<?php

declare(strict_types = 1);

namespace byrokrat\amount\Currency;

/**
 * The Serbian Dinar currency
 *
 * This file has ben auto generated and should not be edited directly
 */
class RSD extends \byrokrat\amount\Currency
{
    public function getCurrencyCode(): string
    {
        return 'RSD';
    }

    public static function getDisplayPrecision(): int
    {
        return 0;
    }
}
