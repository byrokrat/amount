<?php

declare(strict_types = 1);

namespace byrokrat\amount\Currency;

/**
 * The Syrian Pound currency
 *
 * This file has ben auto generated and should not be edited directly
 */
class SYP extends \byrokrat\amount\Currency
{
    public function getCurrencyCode(): string
    {
        return 'SYP';
    }

    public static function getDisplayPrecision(): int
    {
        return 2;
    }
}
