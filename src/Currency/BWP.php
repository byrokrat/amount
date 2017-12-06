<?php

declare(strict_types = 1);

namespace byrokrat\amount\Currency;

/**
 * The Botswana Pula currency
 *
 * This file has ben auto generated and should not be edited directly
 */
class BWP extends \byrokrat\amount\Currency
{
    public function getCurrencyCode(): string
    {
        return 'BWP';
    }

    public static function getDisplayPrecision(): int
    {
        return 2;
    }
}
