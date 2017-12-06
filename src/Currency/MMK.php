<?php

declare(strict_types = 1);

namespace byrokrat\amount\Currency;

/**
 * The Myanmar Kyat currency
 *
 * This file has ben auto generated and should not be edited directly
 */
class MMK extends \byrokrat\amount\Currency
{
    public function getCurrencyCode(): string
    {
        return 'MMK';
    }

    public static function getDisplayPrecision(): int
    {
        return 2;
    }
}
