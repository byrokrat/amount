<?php

declare(strict_types = 1);

namespace byrokrat\amount\Currency;

/**
 * The Panamanian Balboa currency
 *
 * This file has ben auto generated and should not be edited directly
 */
class PAB extends \byrokrat\amount\Currency
{
    public function getCurrencyCode(): string
    {
        return 'PAB';
    }

    public static function getDisplayPrecision(): int
    {
        return 2;
    }
}
