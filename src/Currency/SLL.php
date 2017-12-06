<?php

declare(strict_types = 1);

namespace byrokrat\amount\Currency;

/**
 * The Sierra Leonean Leone currency
 *
 * This file has ben auto generated and should not be edited directly
 */
class SLL extends \byrokrat\amount\Currency
{
    public function getCurrencyCode(): string
    {
        return 'SLL';
    }

    public static function getDisplayPrecision(): int
    {
        return 2;
    }
}
