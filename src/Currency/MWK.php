<?php

declare(strict_types = 1);

namespace byrokrat\amount\Currency;

/**
 * The Malawian Kwacha currency
 *
 * This file has ben auto generated and should not be edited directly
 */
class MWK extends \byrokrat\amount\Currency
{
    public function getCurrencyCode(): string
    {
        return 'MWK';
    }

    public static function getDisplayPrecision(): int
    {
        return 2;
    }
}
