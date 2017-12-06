<?php

declare(strict_types = 1);

namespace byrokrat\amount\Currency;

/**
 * The Guatemalan Quetzal currency
 *
 * This file has ben auto generated and should not be edited directly
 */
class GTQ extends \byrokrat\amount\Currency
{
    public function getCurrencyCode(): string
    {
        return 'GTQ';
    }

    public static function getDisplayPrecision(): int
    {
        return 2;
    }
}
