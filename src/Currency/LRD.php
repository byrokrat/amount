<?php

declare(strict_types = 1);

namespace byrokrat\amount\Currency;

/**
 * The Liberian Dollar currency
 *
 * This file has ben auto generated and should not be edited directly
 */
class LRD extends \byrokrat\amount\Currency
{
    public function getCurrencyCode(): string
    {
        return 'LRD';
    }

    public static function getDisplayPrecision(): int
    {
        return 2;
    }
}
