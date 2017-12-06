<?php

declare(strict_types = 1);

namespace byrokrat\amount\Currency;

/**
 * The Ugandan Shilling currency
 *
 * This file has ben auto generated and should not be edited directly
 */
class UGX extends \byrokrat\amount\Currency
{
    public function getCurrencyCode(): string
    {
        return 'UGX';
    }

    public static function getDisplayPrecision(): int
    {
        return 0;
    }
}
