<?php

declare(strict_types = 1);

namespace byrokrat\amount\Currency;

/**
 * The Maldivian Rufiyaa currency
 *
 * This file has ben auto generated and should not be edited directly
 */
class MVR extends \byrokrat\amount\Currency
{
    public function getCurrencyCode(): string
    {
        return 'MVR';
    }

    public static function getDisplayPrecision(): int
    {
        return 2;
    }
}
