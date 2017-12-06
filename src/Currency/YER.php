<?php

declare(strict_types = 1);

namespace byrokrat\amount\Currency;

/**
 * The Yemeni Rial currency
 *
 * This file has ben auto generated and should not be edited directly
 */
class YER extends \byrokrat\amount\Currency
{
    public function getCurrencyCode(): string
    {
        return 'YER';
    }

    public static function getDisplayPrecision(): int
    {
        return 2;
    }
}
