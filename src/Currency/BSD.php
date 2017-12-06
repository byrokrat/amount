<?php

declare(strict_types = 1);

namespace byrokrat\amount\Currency;

/**
 * The Bahamian Dollar currency
 *
 * This file has ben auto generated and should not be edited directly
 */
class BSD extends \byrokrat\amount\Currency
{
    public function getCurrencyCode(): string
    {
        return 'BSD';
    }

    public static function getDisplayPrecision(): int
    {
        return 2;
    }
}
