<?php

declare(strict_types = 1);

namespace byrokrat\amount\Currency;

/**
 * The Honduran Lempira currency
 *
 * This file has ben auto generated and should not be edited directly
 */
class HNL extends \byrokrat\amount\Currency
{
    public function getCurrencyCode(): string
    {
        return 'HNL';
    }

    public static function getDisplayPrecision(): int
    {
        return 2;
    }
}
