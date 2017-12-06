<?php

declare(strict_types = 1);

namespace byrokrat\amount\Currency;

/**
 * The Armenian Dram currency
 *
 * This file has ben auto generated and should not be edited directly
 */
class AMD extends \byrokrat\amount\Currency
{
    public function getCurrencyCode(): string
    {
        return 'AMD';
    }

    public static function getDisplayPrecision(): int
    {
        return 2;
    }
}
