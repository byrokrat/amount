<?php

declare(strict_types = 1);

namespace byrokrat\amount\Currency;

/**
 * The Jamaican Dollar currency
 *
 * This file has ben auto generated and should not be edited directly
 */
class JMD extends \byrokrat\amount\Currency
{
    public function getCurrencyCode(): string
    {
        return 'JMD';
    }

    public static function getDisplayPrecision(): int
    {
        return 2;
    }
}
