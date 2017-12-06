<?php

declare(strict_types = 1);

namespace byrokrat\amount\Currency;

/**
 * The South African Rand currency
 *
 * This file has ben auto generated and should not be edited directly
 */
class ZAR extends \byrokrat\amount\Currency
{
    public function getCurrencyCode(): string
    {
        return 'ZAR';
    }

    public static function getDisplayPrecision(): int
    {
        return 2;
    }
}
