<?php

declare(strict_types = 1);

namespace byrokrat\amount\Currency;

/**
 * The Costa Rican Colon currency
 *
 * This file has ben auto generated and should not be edited directly
 */
class CRC extends \byrokrat\amount\Currency
{
    public function getCurrencyCode(): string
    {
        return 'CRC';
    }

    public static function getDisplayPrecision(): int
    {
        return 2;
    }
}
