<?php

declare(strict_types = 1);

namespace byrokrat\amount\Currency;

/**
 * The Cuban Peso currency
 *
 * This file has ben auto generated and should not be edited directly
 */
class CUP extends \byrokrat\amount\Currency
{
    public function getCurrencyCode(): string
    {
        return 'CUP';
    }

    public static function getDisplayPrecision(): int
    {
        return 2;
    }
}
