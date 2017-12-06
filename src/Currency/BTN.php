<?php

declare(strict_types = 1);

namespace byrokrat\amount\Currency;

/**
 * The Bhutanese Ngultrum currency
 *
 * This file has ben auto generated and should not be edited directly
 */
class BTN extends \byrokrat\amount\Currency
{
    public function getCurrencyCode(): string
    {
        return 'BTN';
    }

    public static function getDisplayPrecision(): int
    {
        return 2;
    }
}
