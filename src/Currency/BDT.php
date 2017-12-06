<?php

declare(strict_types = 1);

namespace byrokrat\amount\Currency;

/**
 * The Bangladeshi Taka currency
 *
 * This file has ben auto generated and should not be edited directly
 */
class BDT extends \byrokrat\amount\Currency
{
    public function getCurrencyCode(): string
    {
        return 'BDT';
    }

    public static function getDisplayPrecision(): int
    {
        return 2;
    }
}
