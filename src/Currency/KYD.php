<?php

declare(strict_types = 1);

namespace byrokrat\amount\Currency;

/**
 * The Cayman Islands Dollar currency
 *
 * This file has ben auto generated and should not be edited directly
 */
class KYD extends \byrokrat\amount\Currency
{
    public function getCurrencyCode(): string
    {
        return 'KYD';
    }

    public static function getDisplayPrecision(): int
    {
        return 2;
    }
}
