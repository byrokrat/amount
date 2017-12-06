<?php

declare(strict_types = 1);

namespace byrokrat\amount\Currency;

/**
 * The Euro currency
 *
 * This file has ben auto generated and should not be edited directly
 */
class EUR extends \byrokrat\amount\Currency
{
    public function getCurrencyCode(): string
    {
        return 'EUR';
    }

    public static function getDisplayPrecision(): int
    {
        return 2;
    }
}
