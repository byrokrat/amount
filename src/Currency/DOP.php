<?php

declare(strict_types = 1);

namespace byrokrat\amount\Currency;

/**
 * The Dominican Peso currency
 *
 * This file has ben auto generated and should not be edited directly
 */
class DOP extends \byrokrat\amount\Currency
{
    public function getCurrencyCode(): string
    {
        return 'DOP';
    }

    public static function getDisplayPrecision(): int
    {
        return 2;
    }
}
