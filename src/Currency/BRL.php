<?php

declare(strict_types = 1);

namespace byrokrat\amount\Currency;

/**
 * The Brazilian Real currency
 *
 * This file has ben auto generated and should not be edited directly
 */
class BRL extends \byrokrat\amount\Currency
{
    public function getCurrencyCode(): string
    {
        return 'BRL';
    }

    public static function getDisplayPrecision(): int
    {
        return 2;
    }
}
