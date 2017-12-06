<?php

declare(strict_types = 1);

namespace byrokrat\amount\Currency;

/**
 * The Malagasy Ariary currency
 *
 * This file has ben auto generated and should not be edited directly
 */
class MGA extends \byrokrat\amount\Currency
{
    public function getCurrencyCode(): string
    {
        return 'MGA';
    }

    public static function getDisplayPrecision(): int
    {
        return 0;
    }
}
