<?php

declare(strict_types = 1);

namespace byrokrat\amount\Currency;

/**
 * The Australian Dollar currency
 *
 * This file has ben auto generated and should not be edited directly
 */
class AUD extends \byrokrat\amount\Currency
{
    public function getCurrencyCode(): string
    {
        return 'AUD';
    }

    public static function getDisplayPrecision(): int
    {
        return 2;
    }
}
