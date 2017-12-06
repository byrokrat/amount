<?php

declare(strict_types = 1);

namespace byrokrat\amount\Currency;

/**
 * The Canadian Dollar currency
 *
 * This file has ben auto generated and should not be edited directly
 */
class CAD extends \byrokrat\amount\Currency
{
    public function getCurrencyCode(): string
    {
        return 'CAD';
    }

    public static function getDisplayPrecision(): int
    {
        return 2;
    }
}
