<?php

declare(strict_types = 1);

namespace byrokrat\amount\Currency;

/**
 * The Solomon Islands Dollar currency
 *
 * This file has ben auto generated and should not be edited directly
 */
class SBD extends \byrokrat\amount\Currency
{
    public function getCurrencyCode(): string
    {
        return 'SBD';
    }

    public static function getDisplayPrecision(): int
    {
        return 2;
    }
}
