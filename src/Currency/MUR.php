<?php

declare(strict_types = 1);

namespace byrokrat\amount\Currency;

/**
 * The Mauritian Rupee currency
 *
 * This file has ben auto generated and should not be edited directly
 */
class MUR extends \byrokrat\amount\Currency
{
    public function getCurrencyCode(): string
    {
        return 'MUR';
    }

    public static function getDisplayPrecision(): int
    {
        return 2;
    }
}
