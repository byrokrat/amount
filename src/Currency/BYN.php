<?php

declare(strict_types = 1);

namespace byrokrat\amount\Currency;

/**
 * The Belarussian Ruble currency
 *
 * This file has ben auto generated and should not be edited directly
 */
class BYN extends \byrokrat\amount\Currency
{
    public function getCurrencyCode(): string
    {
        return 'BYN';
    }

    public static function getDisplayPrecision(): int
    {
        return 2;
    }
}
