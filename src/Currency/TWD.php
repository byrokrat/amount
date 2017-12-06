<?php

declare(strict_types = 1);

namespace byrokrat\amount\Currency;

/**
 * The New Taiwan Dollar currency
 *
 * This file has ben auto generated and should not be edited directly
 */
class TWD extends \byrokrat\amount\Currency
{
    public function getCurrencyCode(): string
    {
        return 'TWD';
    }

    public static function getDisplayPrecision(): int
    {
        return 2;
    }
}
