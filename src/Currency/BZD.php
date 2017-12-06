<?php

declare(strict_types = 1);

namespace byrokrat\amount\Currency;

/**
 * The Belize Dollar currency
 *
 * This file has ben auto generated and should not be edited directly
 */
class BZD extends \byrokrat\amount\Currency
{
    public function getCurrencyCode(): string
    {
        return 'BZD';
    }

    public static function getDisplayPrecision(): int
    {
        return 2;
    }
}
