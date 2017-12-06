<?php

declare(strict_types = 1);

namespace byrokrat\amount\Currency;

/**
 * The Ukrainian Hryvnia currency
 *
 * This file has ben auto generated and should not be edited directly
 */
class UAH extends \byrokrat\amount\Currency
{
    public function getCurrencyCode(): string
    {
        return 'UAH';
    }

    public static function getDisplayPrecision(): int
    {
        return 2;
    }
}
