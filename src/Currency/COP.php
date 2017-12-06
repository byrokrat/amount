<?php

declare(strict_types = 1);

namespace byrokrat\amount\Currency;

/**
 * The Colombian Peso currency
 *
 * This file has ben auto generated and should not be edited directly
 */
class COP extends \byrokrat\amount\Currency
{
    public function getCurrencyCode(): string
    {
        return 'COP';
    }

    public static function getDisplayPrecision(): int
    {
        return 2;
    }
}
