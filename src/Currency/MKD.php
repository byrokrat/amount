<?php

declare(strict_types = 1);

namespace byrokrat\amount\Currency;

/**
 * The Macedonian Denar currency
 *
 * This file has ben auto generated and should not be edited directly
 */
class MKD extends \byrokrat\amount\Currency
{
    public function getCurrencyCode(): string
    {
        return 'MKD';
    }

    public static function getDisplayPrecision(): int
    {
        return 2;
    }
}
