<?php

declare(strict_types = 1);

namespace byrokrat\amount\Currency;

/**
 * The Boliviano currency
 *
 * This file has ben auto generated and should not be edited directly
 */
class BOB extends \byrokrat\amount\Currency
{
    public function getCurrencyCode(): string
    {
        return 'BOB';
    }

    public static function getDisplayPrecision(): int
    {
        return 2;
    }
}
