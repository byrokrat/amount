<?php

declare(strict_types = 1);

namespace byrokrat\amount\Currency;

/**
 * The Icelandic Króna currency
 *
 * This file has ben auto generated and should not be edited directly
 */
class ISK extends \byrokrat\amount\Currency
{
    public function getCurrencyCode(): string
    {
        return 'ISK';
    }

    public static function getDisplayPrecision(): int
    {
        return 0;
    }
}
