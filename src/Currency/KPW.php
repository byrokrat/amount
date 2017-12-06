<?php

declare(strict_types = 1);

namespace byrokrat\amount\Currency;

/**
 * The North Korean Won currency
 *
 * This file has ben auto generated and should not be edited directly
 */
class KPW extends \byrokrat\amount\Currency
{
    public function getCurrencyCode(): string
    {
        return 'KPW';
    }

    public static function getDisplayPrecision(): int
    {
        return 2;
    }
}
