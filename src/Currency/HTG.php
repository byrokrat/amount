<?php

declare(strict_types = 1);

namespace byrokrat\amount\Currency;

/**
 * The Haitian Gourde currency
 *
 * This file has ben auto generated and should not be edited directly
 */
class HTG extends \byrokrat\amount\Currency
{
    public function getCurrencyCode(): string
    {
        return 'HTG';
    }

    public static function getDisplayPrecision(): int
    {
        return 2;
    }
}
