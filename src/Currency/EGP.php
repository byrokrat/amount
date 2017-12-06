<?php

declare(strict_types = 1);

namespace byrokrat\amount\Currency;

/**
 * The Egyptian Pound currency
 *
 * This file has ben auto generated and should not be edited directly
 */
class EGP extends \byrokrat\amount\Currency
{
    public function getCurrencyCode(): string
    {
        return 'EGP';
    }

    public static function getDisplayPrecision(): int
    {
        return 2;
    }
}
