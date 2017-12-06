<?php

declare(strict_types = 1);

namespace byrokrat\amount\Currency;

/**
 * The Venezuelan Bolivar currency
 *
 * This file has ben auto generated and should not be edited directly
 */
class VEF extends \byrokrat\amount\Currency
{
    public function getCurrencyCode(): string
    {
        return 'VEF';
    }

    public static function getDisplayPrecision(): int
    {
        return 2;
    }
}
