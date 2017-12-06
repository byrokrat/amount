<?php

declare(strict_types = 1);

namespace byrokrat\amount\Currency;

/**
 * The Tajikistani Somoni currency
 *
 * This file has ben auto generated and should not be edited directly
 */
class TJS extends \byrokrat\amount\Currency
{
    public function getCurrencyCode(): string
    {
        return 'TJS';
    }

    public static function getDisplayPrecision(): int
    {
        return 2;
    }
}
