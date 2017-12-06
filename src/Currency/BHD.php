<?php

declare(strict_types = 1);

namespace byrokrat\amount\Currency;

/**
 * The Bahraini Dinar currency
 *
 * This file has ben auto generated and should not be edited directly
 */
class BHD extends \byrokrat\amount\Currency
{
    public function getCurrencyCode(): string
    {
        return 'BHD';
    }

    public static function getDisplayPrecision(): int
    {
        return 3;
    }
}
