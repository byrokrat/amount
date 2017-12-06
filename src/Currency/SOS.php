<?php

declare(strict_types = 1);

namespace byrokrat\amount\Currency;

/**
 * The Somali Shilling currency
 *
 * This file has ben auto generated and should not be edited directly
 */
class SOS extends \byrokrat\amount\Currency
{
    public function getCurrencyCode(): string
    {
        return 'SOS';
    }

    public static function getDisplayPrecision(): int
    {
        return 2;
    }
}
