<?php

declare(strict_types = 1);

namespace byrokrat\amount\Currency;

/**
 * The Jordanian Dinar currency
 *
 * This file has ben auto generated and should not be edited directly
 */
class JOD extends \byrokrat\amount\Currency
{
    public function getCurrencyCode(): string
    {
        return 'JOD';
    }

    public static function getDisplayPrecision(): int
    {
        return 3;
    }
}
