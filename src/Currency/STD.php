<?php

declare(strict_types = 1);

namespace byrokrat\amount\Currency;

/**
 * The São Tomé and Principe Dobra currency
 *
 * This file has ben auto generated and should not be edited directly
 */
class STD extends \byrokrat\amount\Currency
{
    public function getCurrencyCode(): string
    {
        return 'STD';
    }

    public static function getDisplayPrecision(): int
    {
        return 2;
    }
}
