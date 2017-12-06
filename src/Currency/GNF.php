<?php

declare(strict_types = 1);

namespace byrokrat\amount\Currency;

/**
 * The Guinean Franc currency
 *
 * This file has ben auto generated and should not be edited directly
 */
class GNF extends \byrokrat\amount\Currency
{
    public function getCurrencyCode(): string
    {
        return 'GNF';
    }

    public static function getDisplayPrecision(): int
    {
        return 0;
    }
}
