<?php

declare(strict_types = 1);

namespace byrokrat\amount\Currency;

/**
 * The East Caribbean Dollar currency
 *
 * This file has ben auto generated and should not be edited directly
 */
class XCD extends \byrokrat\amount\Currency
{
    public function getCurrencyCode(): string
    {
        return 'XCD';
    }

    public static function getDisplayPrecision(): int
    {
        return 2;
    }
}
