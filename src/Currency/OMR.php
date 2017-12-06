<?php

declare(strict_types = 1);

namespace byrokrat\amount\Currency;

/**
 * The Omani Rial currency
 *
 * This file has ben auto generated and should not be edited directly
 */
class OMR extends \byrokrat\amount\Currency
{
    public function getCurrencyCode(): string
    {
        return 'OMR';
    }

    public static function getDisplayPrecision(): int
    {
        return 3;
    }
}
