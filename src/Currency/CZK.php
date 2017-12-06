<?php

declare(strict_types = 1);

namespace byrokrat\amount\Currency;

/**
 * The Czech Koruna currency
 *
 * This file has ben auto generated and should not be edited directly
 */
class CZK extends \byrokrat\amount\Currency
{
    public function getCurrencyCode(): string
    {
        return 'CZK';
    }

    public static function getDisplayPrecision(): int
    {
        return 2;
    }
}
