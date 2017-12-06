<?php

declare(strict_types = 1);

namespace byrokrat\amount\Currency;

/**
 * The Libyan Dinar currency
 *
 * This file has ben auto generated and should not be edited directly
 */
class LYD extends \byrokrat\amount\Currency
{
    public function getCurrencyCode(): string
    {
        return 'LYD';
    }

    public static function getDisplayPrecision(): int
    {
        return 3;
    }
}
