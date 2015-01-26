<?php

namespace byrokrat\amount\Currency;

/**
 * The Euro currency
 */
class EUR extends \byrokrat\amount\Currency
{
    /**
     * Get ISO-4217 currency name
     *
     * @return string
     */
    public function getCurrencyCode()
    {
        return 'EUR';
    }
}
