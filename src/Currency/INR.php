<?php

declare(strict_types = 1);

namespace byrokrat\amount\Currency;

/**
 * The Indian Rupee currency
 *
 * This file has ben auto generated and should not be edited directly
 */
class INR extends \byrokrat\amount\Currency
{
    public function getCurrencyCode(): string
    {
        return 'INR';
    }

    public static function getDisplayPrecision(): int
    {
        return 2;
    }
}
