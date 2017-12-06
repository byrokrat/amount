<?php

declare(strict_types = 1);

namespace byrokrat\amount\Currency;

/**
 * The Nepalese Rupee currency
 *
 * This file has ben auto generated and should not be edited directly
 */
class NPR extends \byrokrat\amount\Currency
{
    public function getCurrencyCode(): string
    {
        return 'NPR';
    }

    public static function getDisplayPrecision(): int
    {
        return 2;
    }
}
