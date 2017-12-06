<?php

declare(strict_types = 1);

namespace byrokrat\amount\Currency;

/**
 * The Falkland Islands Pound currency
 *
 * This file has ben auto generated and should not be edited directly
 */
class FKP extends \byrokrat\amount\Currency
{
    public function getCurrencyCode(): string
    {
        return 'FKP';
    }

    public static function getDisplayPrecision(): int
    {
        return 2;
    }
}
