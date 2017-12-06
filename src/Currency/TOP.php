<?php

declare(strict_types = 1);

namespace byrokrat\amount\Currency;

/**
 * The Tongan Paʻanga currency
 *
 * This file has ben auto generated and should not be edited directly
 */
class TOP extends \byrokrat\amount\Currency
{
    public function getCurrencyCode(): string
    {
        return 'TOP';
    }

    public static function getDisplayPrecision(): int
    {
        return 2;
    }
}
