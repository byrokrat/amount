<?php

declare(strict_types = 1);

namespace byrokrat\amount\Currency;

/**
 * The Tunisian Dinar currency
 *
 * This file has ben auto generated and should not be edited directly
 */
class TND extends \byrokrat\amount\Currency
{
    public function getCurrencyCode(): string
    {
        return 'TND';
    }

    public static function getDisplayPrecision(): int
    {
        return 3;
    }
}
