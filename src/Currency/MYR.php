<?php

declare(strict_types = 1);

namespace byrokrat\amount\Currency;

/**
 * The Malaysian Ringgit currency
 *
 * This file has ben auto generated and should not be edited directly
 */
class MYR extends \byrokrat\amount\Currency
{
    public function getCurrencyCode(): string
    {
        return 'MYR';
    }

    public static function getDisplayPrecision(): int
    {
        return 2;
    }
}
