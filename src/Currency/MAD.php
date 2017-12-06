<?php

declare(strict_types = 1);

namespace byrokrat\amount\Currency;

/**
 * The Moroccan Dirham currency
 *
 * This file has ben auto generated and should not be edited directly
 */
class MAD extends \byrokrat\amount\Currency
{
    public function getCurrencyCode(): string
    {
        return 'MAD';
    }

    public static function getDisplayPrecision(): int
    {
        return 2;
    }
}
