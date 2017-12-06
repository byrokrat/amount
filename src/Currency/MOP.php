<?php

declare(strict_types = 1);

namespace byrokrat\amount\Currency;

/**
 * The Macanese Pataca currency
 *
 * This file has ben auto generated and should not be edited directly
 */
class MOP extends \byrokrat\amount\Currency
{
    public function getCurrencyCode(): string
    {
        return 'MOP';
    }

    public static function getDisplayPrecision(): int
    {
        return 2;
    }
}
