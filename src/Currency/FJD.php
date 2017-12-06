<?php

declare(strict_types = 1);

namespace byrokrat\amount\Currency;

/**
 * The Fiji Dollar currency
 *
 * This file has ben auto generated and should not be edited directly
 */
class FJD extends \byrokrat\amount\Currency
{
    public function getCurrencyCode(): string
    {
        return 'FJD';
    }

    public static function getDisplayPrecision(): int
    {
        return 2;
    }
}
