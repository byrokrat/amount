<?php

declare(strict_types = 1);

namespace byrokrat\amount\Currency;

/**
 * The Peruvian Nuevo Sol currency
 *
 * This file has ben auto generated and should not be edited directly
 */
class PEN extends \byrokrat\amount\Currency
{
    public function getCurrencyCode(): string
    {
        return 'PEN';
    }

    public static function getDisplayPrecision(): int
    {
        return 2;
    }
}
