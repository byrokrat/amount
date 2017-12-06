<?php

declare(strict_types = 1);

namespace byrokrat\amount\Currency;

/**
 * The CFP Franc currency
 *
 * This file has ben auto generated and should not be edited directly
 */
class XPF extends \byrokrat\amount\Currency
{
    public function getCurrencyCode(): string
    {
        return 'XPF';
    }

    public static function getDisplayPrecision(): int
    {
        return 0;
    }
}
