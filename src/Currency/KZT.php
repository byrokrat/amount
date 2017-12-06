<?php

declare(strict_types = 1);

namespace byrokrat\amount\Currency;

/**
 * The Kazakhstani Tenge currency
 *
 * This file has ben auto generated and should not be edited directly
 */
class KZT extends \byrokrat\amount\Currency
{
    public function getCurrencyCode(): string
    {
        return 'KZT';
    }

    public static function getDisplayPrecision(): int
    {
        return 2;
    }
}
