<?php

declare(strict_types = 1);

namespace byrokrat\amount\Currency;

/**
 * The Lebanese Pound currency
 *
 * This file has ben auto generated and should not be edited directly
 */
class LBP extends \byrokrat\amount\Currency
{
    public function getCurrencyCode(): string
    {
        return 'LBP';
    }

    public static function getDisplayPrecision(): int
    {
        return 2;
    }
}
