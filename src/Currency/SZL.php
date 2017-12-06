<?php

declare(strict_types = 1);

namespace byrokrat\amount\Currency;

/**
 * The Swazi Lilangeni currency
 *
 * This file has ben auto generated and should not be edited directly
 */
class SZL extends \byrokrat\amount\Currency
{
    public function getCurrencyCode(): string
    {
        return 'SZL';
    }

    public static function getDisplayPrecision(): int
    {
        return 2;
    }
}
