<?php

declare(strict_types = 1);

namespace byrokrat\amount\Currency;

/**
 * The Iraqi Dinar currency
 *
 * This file has ben auto generated and should not be edited directly
 */
class IQD extends \byrokrat\amount\Currency
{
    public function getCurrencyCode(): string
    {
        return 'IQD';
    }

    public static function getDisplayPrecision(): int
    {
        return 3;
    }
}
