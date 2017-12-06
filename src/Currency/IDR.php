<?php

declare(strict_types = 1);

namespace byrokrat\amount\Currency;

/**
 * The Indonesian Rupiah currency
 *
 * This file has ben auto generated and should not be edited directly
 */
class IDR extends \byrokrat\amount\Currency
{
    public function getCurrencyCode(): string
    {
        return 'IDR';
    }

    public static function getDisplayPrecision(): int
    {
        return 2;
    }
}
