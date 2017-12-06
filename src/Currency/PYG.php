<?php

declare(strict_types = 1);

namespace byrokrat\amount\Currency;

/**
 * The Paraguayan Guarani currency
 *
 * This file has ben auto generated and should not be edited directly
 */
class PYG extends \byrokrat\amount\Currency
{
    public function getCurrencyCode(): string
    {
        return 'PYG';
    }

    public static function getDisplayPrecision(): int
    {
        return 0;
    }
}
