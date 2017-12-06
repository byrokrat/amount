<?php

declare(strict_types = 1);

namespace byrokrat\amount\Currency;

/**
 * The Vietnamese Dong currency
 *
 * This file has ben auto generated and should not be edited directly
 */
class VND extends \byrokrat\amount\Currency
{
    public function getCurrencyCode(): string
    {
        return 'VND';
    }

    public static function getDisplayPrecision(): int
    {
        return 0;
    }
}
