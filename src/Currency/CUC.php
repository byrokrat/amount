<?php

declare(strict_types = 1);

namespace byrokrat\amount\Currency;

/**
 * The Cuban Convertible Peso currency
 *
 * This file has ben auto generated and should not be edited directly
 */
class CUC extends \byrokrat\amount\Currency
{
    public function getCurrencyCode(): string
    {
        return 'CUC';
    }

    public static function getDisplayPrecision(): int
    {
        return 2;
    }
}
