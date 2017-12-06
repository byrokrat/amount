<?php

declare(strict_types = 1);

namespace byrokrat\amount\Currency;

/**
 * The Cambodian Riel currency
 *
 * This file has ben auto generated and should not be edited directly
 */
class KHR extends \byrokrat\amount\Currency
{
    public function getCurrencyCode(): string
    {
        return 'KHR';
    }

    public static function getDisplayPrecision(): int
    {
        return 2;
    }
}
