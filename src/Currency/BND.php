<?php

declare(strict_types = 1);

namespace byrokrat\amount\Currency;

/**
 * The Brunei Dollar currency
 *
 * This file has ben auto generated and should not be edited directly
 */
class BND extends \byrokrat\amount\Currency
{
    public function getCurrencyCode(): string
    {
        return 'BND';
    }

    public static function getDisplayPrecision(): int
    {
        return 2;
    }
}
