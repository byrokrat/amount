<?php

declare(strict_types = 1);

namespace byrokrat\amount\Currency;

/**
 * The Albanian Lek currency
 *
 * This file has ben auto generated and should not be edited directly
 */
class ALL extends \byrokrat\amount\Currency
{
    public function getCurrencyCode(): string
    {
        return 'ALL';
    }

    public static function getDisplayPrecision(): int
    {
        return 2;
    }
}
