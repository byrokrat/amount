<?php

declare(strict_types = 1);

namespace byrokrat\amount\Currency;

/**
 * The Cape Verde Escudo currency
 *
 * This file has ben auto generated and should not be edited directly
 */
class CVE extends \byrokrat\amount\Currency
{
    public function getCurrencyCode(): string
    {
        return 'CVE';
    }

    public static function getDisplayPrecision(): int
    {
        return 2;
    }
}
