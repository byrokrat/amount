<?php

declare(strict_types = 1);

namespace byrokrat\amount\Currency;

/**
 * The New Zealand Dollar currency
 *
 * This file has ben auto generated and should not be edited directly
 */
class NZD extends \byrokrat\amount\Currency
{
    public function getCurrencyCode(): string
    {
        return 'NZD';
    }

    public static function getDisplayPrecision(): int
    {
        return 2;
    }
}
