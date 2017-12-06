<?php

declare(strict_types = 1);

namespace byrokrat\amount\Currency;

/**
 * The South Sudanese Pound currency
 *
 * This file has ben auto generated and should not be edited directly
 */
class SSP extends \byrokrat\amount\Currency
{
    public function getCurrencyCode(): string
    {
        return 'SSP';
    }

    public static function getDisplayPrecision(): int
    {
        return 2;
    }
}
