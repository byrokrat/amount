<?php

declare(strict_types = 1);

namespace byrokrat\amount\Currency;

/**
 * The Gibraltar Pound currency
 *
 * This file has ben auto generated and should not be edited directly
 */
class GIP extends \byrokrat\amount\Currency
{
    public function getCurrencyCode(): string
    {
        return 'GIP';
    }

    public static function getDisplayPrecision(): int
    {
        return 2;
    }
}
