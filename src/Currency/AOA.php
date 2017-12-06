<?php

declare(strict_types = 1);

namespace byrokrat\amount\Currency;

/**
 * The Angolan Kwanza currency
 *
 * This file has ben auto generated and should not be edited directly
 */
class AOA extends \byrokrat\amount\Currency
{
    public function getCurrencyCode(): string
    {
        return 'AOA';
    }

    public static function getDisplayPrecision(): int
    {
        return 2;
    }
}
