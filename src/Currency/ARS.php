<?php

declare(strict_types = 1);

namespace byrokrat\amount\Currency;

/**
 * The Argentine Peso currency
 *
 * This file has ben auto generated and should not be edited directly
 */
class ARS extends \byrokrat\amount\Currency
{
    public function getCurrencyCode(): string
    {
        return 'ARS';
    }

    public static function getDisplayPrecision(): int
    {
        return 2;
    }
}
