<?php
/**
 * This program is free software. It comes without any warranty, to
 * the extent permitted by applicable law. You can redistribute it
 * and/or modify it under the terms of the Do What The Fuck You Want
 * To Public License, Version 2, as published by Sam Hocevar. See
 * http://www.wtfpl.net/ for more details.
 */

namespace ledgr\amount\Currency;

/**
 * Euro
 *
 * @author Hannes Forsgård <hannes.forsgard@fripost.org>
 */
class EUR extends \ledgr\amount\Currency
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