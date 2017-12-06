<?php

declare(strict_types = 1);

namespace byrokrat\amount\Currency;

/**
 * The Chilean Peso currency
 *
 * This file has ben auto generated and should not be edited directly
 */
class CLP extends \byrokrat\amount\Currency
{
    public function getCurrencyCode(): string
    {
        return 'CLP';
    }

    public static function getDisplayPrecision(): int
    {
        return 0;
    }
}
