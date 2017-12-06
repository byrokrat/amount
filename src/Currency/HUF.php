<?php

declare(strict_types = 1);

namespace byrokrat\amount\Currency;

/**
 * The Hungarian Forint currency
 *
 * This file has ben auto generated and should not be edited directly
 */
class HUF extends \byrokrat\amount\Currency
{
    public function getCurrencyCode(): string
    {
        return 'HUF';
    }

    public static function getDisplayPrecision(): int
    {
        return 2;
    }
}
