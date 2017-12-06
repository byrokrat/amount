<?php

declare(strict_types = 1);

namespace byrokrat\amount\Currency;

/**
 * The Congolese Franc currency
 *
 * This file has ben auto generated and should not be edited directly
 */
class CDF extends \byrokrat\amount\Currency
{
    public function getCurrencyCode(): string
    {
        return 'CDF';
    }

    public static function getDisplayPrecision(): int
    {
        return 2;
    }
}
