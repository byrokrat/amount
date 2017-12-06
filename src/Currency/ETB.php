<?php

declare(strict_types = 1);

namespace byrokrat\amount\Currency;

/**
 * The Ethiopian Birr currency
 *
 * This file has ben auto generated and should not be edited directly
 */
class ETB extends \byrokrat\amount\Currency
{
    public function getCurrencyCode(): string
    {
        return 'ETB';
    }

    public static function getDisplayPrecision(): int
    {
        return 2;
    }
}
