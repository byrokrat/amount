<?php

declare(strict_types = 1);

namespace byrokrat\amount\Currency;

/**
 * The Hong Kong Dollar currency
 *
 * This file has ben auto generated and should not be edited directly
 */
class HKD extends \byrokrat\amount\Currency
{
    public function getCurrencyCode(): string
    {
        return 'HKD';
    }

    public static function getDisplayPrecision(): int
    {
        return 2;
    }
}
