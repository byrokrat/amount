<?php

declare(strict_types = 1);

namespace byrokrat\amount\Currency;

/**
 * The Qatari Rial currency
 *
 * This file has ben auto generated and should not be edited directly
 */
class QAR extends \byrokrat\amount\Currency
{
    public function getCurrencyCode(): string
    {
        return 'QAR';
    }

    public static function getDisplayPrecision(): int
    {
        return 2;
    }
}
