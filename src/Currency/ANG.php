<?php

declare(strict_types = 1);

namespace byrokrat\amount\Currency;

/**
 * The Netherlands Antillean Guilder currency
 *
 * This file has ben auto generated and should not be edited directly
 */
class ANG extends \byrokrat\amount\Currency
{
    public function getCurrencyCode(): string
    {
        return 'ANG';
    }

    public static function getDisplayPrecision(): int
    {
        return 2;
    }
}
