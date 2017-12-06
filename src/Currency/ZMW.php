<?php

declare(strict_types = 1);

namespace byrokrat\amount\Currency;

/**
 * The Zambian Kwacha currency
 *
 * This file has ben auto generated and should not be edited directly
 */
class ZMW extends \byrokrat\amount\Currency
{
    public function getCurrencyCode(): string
    {
        return 'ZMW';
    }

    public static function getDisplayPrecision(): int
    {
        return 2;
    }
}
