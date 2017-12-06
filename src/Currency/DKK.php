<?php

declare(strict_types = 1);

namespace byrokrat\amount\Currency;

/**
 * The Danish Krone currency
 *
 * This file has ben auto generated and should not be edited directly
 */
class DKK extends \byrokrat\amount\Currency
{
    public function getCurrencyCode(): string
    {
        return 'DKK';
    }

    public static function getDisplayPrecision(): int
    {
        return 2;
    }
}
