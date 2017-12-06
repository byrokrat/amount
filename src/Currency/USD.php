<?php

declare(strict_types = 1);

namespace byrokrat\amount\Currency;

/**
 * The US Dollar currency
 *
 * This file has ben auto generated and should not be edited directly
 */
class USD extends \byrokrat\amount\Currency
{
    public function getCurrencyCode(): string
    {
        return 'USD';
    }

    public static function getDisplayPrecision(): int
    {
        return 2;
    }
}
