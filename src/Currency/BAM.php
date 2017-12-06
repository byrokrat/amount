<?php

declare(strict_types = 1);

namespace byrokrat\amount\Currency;

/**
 * The Bosnia and Herzegovina Convertible Mark currency
 *
 * This file has ben auto generated and should not be edited directly
 */
class BAM extends \byrokrat\amount\Currency
{
    public function getCurrencyCode(): string
    {
        return 'BAM';
    }

    public static function getDisplayPrecision(): int
    {
        return 2;
    }
}
