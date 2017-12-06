<?php

declare(strict_types = 1);

namespace byrokrat\amount\Currency;

/**
 * The Barbados Dollar currency
 *
 * This file has ben auto generated and should not be edited directly
 */
class BBD extends \byrokrat\amount\Currency
{
    public function getCurrencyCode(): string
    {
        return 'BBD';
    }

    public static function getDisplayPrecision(): int
    {
        return 2;
    }
}
