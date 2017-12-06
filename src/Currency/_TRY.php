<?php

declare(strict_types = 1);

namespace byrokrat\amount\Currency;

/**
 * The Turkish Lira currency
 *
 * This file has ben auto generated and should not be edited directly
 */
class _TRY extends \byrokrat\amount\Currency
{
    public function getCurrencyCode(): string
    {
        return 'TRY';
    }

    public static function getDisplayPrecision(): int
    {
        return 2;
    }
}
