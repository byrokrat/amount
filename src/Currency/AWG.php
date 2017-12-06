<?php

declare(strict_types = 1);

namespace byrokrat\amount\Currency;

/**
 * The Aruban Florin currency
 *
 * This file has ben auto generated and should not be edited directly
 */
class AWG extends \byrokrat\amount\Currency
{
    public function getCurrencyCode(): string
    {
        return 'AWG';
    }

    public static function getDisplayPrecision(): int
    {
        return 2;
    }
}
