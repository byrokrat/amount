<?php

declare(strict_types = 1);

namespace byrokrat\amount\Currency;

/**
 * The Nigerian Naira currency
 *
 * This file has ben auto generated and should not be edited directly
 */
class NGN extends \byrokrat\amount\Currency
{
    public function getCurrencyCode(): string
    {
        return 'NGN';
    }

    public static function getDisplayPrecision(): int
    {
        return 2;
    }
}
