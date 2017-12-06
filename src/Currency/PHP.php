<?php

declare(strict_types = 1);

namespace byrokrat\amount\Currency;

/**
 * The Philippine Peso currency
 *
 * This file has ben auto generated and should not be edited directly
 */
class PHP extends \byrokrat\amount\Currency
{
    public function getCurrencyCode(): string
    {
        return 'PHP';
    }

    public static function getDisplayPrecision(): int
    {
        return 2;
    }
}
