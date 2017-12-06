<?php

declare(strict_types = 1);

namespace byrokrat\amount\Currency;

/**
 * The South Korean Won currency
 *
 * This file has ben auto generated and should not be edited directly
 */
class KRW extends \byrokrat\amount\Currency
{
    public function getCurrencyCode(): string
    {
        return 'KRW';
    }

    public static function getDisplayPrecision(): int
    {
        return 0;
    }
}
