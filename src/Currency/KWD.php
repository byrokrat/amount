<?php

declare(strict_types = 1);

namespace byrokrat\amount\Currency;

/**
 * The Kuwaiti Dinar currency
 *
 * This file has ben auto generated and should not be edited directly
 */
class KWD extends \byrokrat\amount\Currency
{
    public function getCurrencyCode(): string
    {
        return 'KWD';
    }

    public static function getDisplayPrecision(): int
    {
        return 3;
    }
}
