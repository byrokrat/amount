<?php

namespace byrokrat\amount\Currency;

/**
 * The swedish krona
 */
class SEK extends \byrokrat\amount\Currency
{
    /**
     * Get ISO-4217 currency name
     *
     * @return string
     */
    public function getCurrencyCode()
    {
        return 'SEK';
    }
}
