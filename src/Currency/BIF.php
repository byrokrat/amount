<?php

declare(strict_types = 1);

namespace byrokrat\amount\Currency;

/**
 * The Burundian Franc currency
 *
 * This file has ben auto generated and should not be edited directly
 */
class BIF extends \byrokrat\amount\Currency
{
    public function getCurrencyCode(): string
    {
        return 'BIF';
    }

    public static function getDisplayPrecision(): int
    {
        return 0;
    }
}
