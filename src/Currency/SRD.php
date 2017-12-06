<?php

declare(strict_types = 1);

namespace byrokrat\amount\Currency;

/**
 * The Surinamese Dollar currency
 *
 * This file has ben auto generated and should not be edited directly
 */
class SRD extends \byrokrat\amount\Currency
{
    public function getCurrencyCode(): string
    {
        return 'SRD';
    }

    public static function getDisplayPrecision(): int
    {
        return 2;
    }
}
