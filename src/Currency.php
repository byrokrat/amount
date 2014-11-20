<?php
/**
 * This program is free software. It comes without any warranty, to
 * the extent permitted by applicable law. You can redistribute it
 * and/or modify it under the terms of the Do What The Fuck You Want
 * To Public License, Version 2, as published by Sam Hocevar. See
 * http://www.wtfpl.net/ for more details.
 */

namespace ledgr\amount;

/**
 * Abstract base currency class
 *
 * Create currency by extending this class. Prevents addition and other operations
 * on amounts from different currencies.
 *
 * @author Hannes Forsgård <hannes.forsgard@fripost.org>
 */
abstract class Currency extends Amount
{
    /**
     * Create new currency object by exchange from foreign currency
     *
     * @param  Currency $amount The amount to exchange
     * @param  mixed    $rate   The exchange rate used
     * @return Currency
     */
    public static function createFromExchange(Currency $amount, $rate)
    {
        return new static(
            $amount->multiplyWith($rate)->getAmount()
        );
    }

    /**
     * Get ISO-4217 currency name
     *
     * @return string
     */
    abstract public function getCurrencyCode();

    /**
     * Get new Amount with the value of $amount added to instance
     *
     * @param  Amount  $amount
     * @param  integer $precision
     * @return Amount
     */
    public function add(Amount $amount, $precision = -1)
    {
        $this->validateCurrency($amount);
        return parent::add($amount, $precision);
    }

    /**
     * Get new Amount with the value of $amount subtracted from instance
     *
     * @param  Amount  $amount
     * @param  integer $precision
     * @return Amount
     */
    public function subtract(Amount $amount, $precision = -1)
    {
        $this->validateCurrency($amount);
        return parent::subtract($amount, $precision);
    }

    /**
     * Compare to amount
     *
     * @param  Amount  $amount
     * @param  integer $precision
     * @return integer 0 if instance and $amount are equal, 1 if instance is larger, -1 otherwise.
     */
    public function compareTo(Amount $amount, $precision = -1)
    {
        $this->validateCurrency($amount);
        return parent::compareTo($amount, $precision);
    }

    /**
     * Check if instance equals amount
     *
     * @param  Amount  $amount
     * @param  integer $precision
     * @return boolean
     */
    public function equals(Amount $amount, $precision = -1)
    {
        $this->validateCurrency($amount);
        return parent::equals($amount, $precision);
    }

    /**
     * Check if instance is less than amount
     *
     * @param  Amount  $amount
     * @param  integer $precision
     * @return boolean
     */
    public function isLessThan(Amount $amount, $precision = -1)
    {
        $this->validateCurrency($amount);
        return parent::isLessThan($amount, $precision);
    }

    /**
     * Check if instance is less than or equals amount
     *
     * @param  Amount  $amount
     * @param  integer $precision
     * @return boolean
     */
    public function isLessThanOrEquals(Amount $amount, $precision = -1)
    {
        $this->validateCurrency($amount);
        return parent::isLessThanOrEquals($amount, $precision);
    }

    /**
     * Check if instance is greater than amount
     *
     * @param  Amount  $amount
     * @param  integer $precision
     * @return boolean
     */
    public function isGreaterThan(Amount $amount, $precision = -1)
    {
        $this->validateCurrency($amount);
        return parent::isGreaterThan($amount, $precision);
    }

    /**
     * Check if instance is greater than or equals amount
     *
     * @param  Amount  $amount
     * @param  integer $precision
     * @return boolean
     */
    public function isGreaterThanOrEquals(Amount $amount, $precision = -1)
    {
        $this->validateCurrency($amount);
        return parent::isGreaterThanOrEquals($amount, $precision);
    }

    /**
     * Validate that amount is in the expected currency
     *
     * @param  Amount $amount
     * @return void
     * @throws InvalidArgumentException If amount is in an unexpected currency
     */
    protected function validateCurrency(Amount $amount)
    {
        if (!$amount instanceof static) {
            throw new InvalidArgumentException(
                "Object of type " . get_class($this) . " expected, found " . get_class($amount)
            );
        }
    }
}
