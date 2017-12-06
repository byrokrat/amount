<?php

declare(strict_types = 1);

namespace byrokrat\amount\Currency;

/**
 * The Georgian Lari currency
 *
 * This file has ben auto generated and should not be edited directly
 */
class GEL extends \byrokrat\amount\Currency
{
    public function getCurrencyCode(): string
    {
        return 'GEL';
    }

    public static function getDisplayPrecision(): int
    {
        return 2;
    }
}
