<?php

declare(strict_types = 1);

namespace byrokrat\amount\Currency;

/**
 * The Algerian Dinar currency
 *
 * This file has ben auto generated and should not be edited directly
 */
class DZD extends \byrokrat\amount\Currency
{
    public function getCurrencyCode(): string
    {
        return 'DZD';
    }

    public static function getDisplayPrecision(): int
    {
        return 2;
    }
}
