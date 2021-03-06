<?php

declare(strict_types = 1);

namespace byrokrat\amount\Currency;

/**
 * The Azerbaijani Manat currency
 *
 * This file has ben auto generated and should not be edited directly
 */
class AZN extends \byrokrat\amount\Currency
{
    public function getCurrencyCode(): string
    {
        return 'AZN';
    }

    public static function getDisplayPrecision(): int
    {
        return 2;
    }
}
