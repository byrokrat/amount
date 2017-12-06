<?php

declare(strict_types = 1);

namespace byrokrat\amount\Currency;

/**
 * The Kyrgyzstani Som currency
 *
 * This file has ben auto generated and should not be edited directly
 */
class KGS extends \byrokrat\amount\Currency
{
    public function getCurrencyCode(): string
    {
        return 'KGS';
    }

    public static function getDisplayPrecision(): int
    {
        return 2;
    }
}
