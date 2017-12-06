<?php

declare(strict_types = 1);

namespace byrokrat\amount\Currency;

/**
 * The Nicaraguan Córdoba currency
 *
 * This file has ben auto generated and should not be edited directly
 */
class NIO extends \byrokrat\amount\Currency
{
    public function getCurrencyCode(): string
    {
        return 'NIO';
    }

    public static function getDisplayPrecision(): int
    {
        return 2;
    }
}
