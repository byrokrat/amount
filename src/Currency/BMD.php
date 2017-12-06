<?php

declare(strict_types = 1);

namespace byrokrat\amount\Currency;

/**
 * The Bermudian Dollar currency
 *
 * This file has ben auto generated and should not be edited directly
 */
class BMD extends \byrokrat\amount\Currency
{
    public function getCurrencyCode(): string
    {
        return 'BMD';
    }

    public static function getDisplayPrecision(): int
    {
        return 2;
    }
}
