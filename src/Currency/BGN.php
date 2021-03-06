<?php

declare(strict_types = 1);

namespace byrokrat\amount\Currency;

/**
 * The Bulgarian Lev currency
 *
 * This file has ben auto generated and should not be edited directly
 */
class BGN extends \byrokrat\amount\Currency
{
    public function getCurrencyCode(): string
    {
        return 'BGN';
    }

    public static function getDisplayPrecision(): int
    {
        return 2;
    }
}
