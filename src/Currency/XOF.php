<?php

declare(strict_types = 1);

namespace byrokrat\amount\Currency;

/**
 * The CFA Franc BCEAO currency
 *
 * This file has ben auto generated and should not be edited directly
 */
class XOF extends \byrokrat\amount\Currency
{
    public function getCurrencyCode(): string
    {
        return 'XOF';
    }

    public static function getDisplayPrecision(): int
    {
        return 0;
    }
}
