<?php

declare(strict_types = 1);

namespace byrokrat\amount\Currency;

/**
 * The Thai Baht currency
 *
 * This file has ben auto generated and should not be edited directly
 */
class THB extends \byrokrat\amount\Currency
{
    public function getCurrencyCode(): string
    {
        return 'THB';
    }

    public static function getDisplayPrecision(): int
    {
        return 2;
    }
}
