<?php

declare(strict_types = 1);

namespace byrokrat\amount\Currency;

/**
 * The Eritrean Nakfa currency
 *
 * This file has ben auto generated and should not be edited directly
 */
class ERN extends \byrokrat\amount\Currency
{
    public function getCurrencyCode(): string
    {
        return 'ERN';
    }

    public static function getDisplayPrecision(): int
    {
        return 2;
    }
}
