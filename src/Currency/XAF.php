<?php

declare(strict_types = 1);

namespace byrokrat\amount\Currency;

/**
 * The CFA Franc BEAC currency
 *
 * This file has ben auto generated and should not be edited directly
 */
class XAF extends \byrokrat\amount\Currency
{
    public function getCurrencyCode(): string
    {
        return 'XAF';
    }

    public static function getDisplayPrecision(): int
    {
        return 0;
    }
}
