<?php

declare(strict_types = 1);

namespace byrokrat\amount\Currency;

/**
 * The Afghan Afghani currency
 *
 * This file has ben auto generated and should not be edited directly
 */
class AFN extends \byrokrat\amount\Currency
{
    public function getCurrencyCode(): string
    {
        return 'AFN';
    }

    public static function getDisplayPrecision(): int
    {
        return 2;
    }
}
