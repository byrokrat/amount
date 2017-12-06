<?php

declare(strict_types = 1);

namespace byrokrat\amount\Currency;

/**
 * The Russian Ruble currency
 *
 * This file has ben auto generated and should not be edited directly
 */
class RUB extends \byrokrat\amount\Currency
{
    public function getCurrencyCode(): string
    {
        return 'RUB';
    }

    public static function getDisplayPrecision(): int
    {
        return 2;
    }
}
