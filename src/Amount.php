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
 * Value class for working with and representing monetary amounts
 *
 * Uses the bcmath extension for arbitrary floating point arithmetic precision
 *
 * @author Hannes Forsgård <hannes.forsgard@fripost.org>
 */
class Amount
{
    /**
     * @var string Internal amount
     */
    private $amount;

    /**
     * @var array Substitution map for signal strings
     */
    private static $signals = array(
        '0'=>'å', '1'=>'J', '2'=>'K', '3'=>'L', '4'=>'M', '5'=>'N', '6'=>'O', '7'=>'P', '8'=>'Q', '9'=>'R'
    );

    /**
     * Create amount from numerical string
     *
     * @param string $amount
     */
    public function __construct($amount = '0')
    {
        if (!is_string($amount) || !is_numeric($amount)) {
            throw new InvalidAmountException("Amount must be a numerical string");
        }
        $this->amount = $amount;
    }

    /**
     * Create amount from integer or floating point number
     *
     * Note that amount internally is stored as a string. Converting number to
     * string may involve rounding and lead to a loss of precision.
     *
     * @param  int|float $number
     * @return Amount
     * @throws InvalidAmountException If $int is not an integer
     */
    public static function createFromNumber($number)
    {
        if (!is_int($number) && !is_float($number)) {
            throw new InvalidAmountException(
                "createFromNumber() expects an integer or a floating point number"
            );
        }
        return new static(sprintf('%F', $number));
    }

    /**
     * Create amount from a localized formatted string
     *
     * @param  string $strAmount
     * @param  string $point Decimal point character. Replaced with '.' If
     *     omitted omitted the 'mon_decimal_point' value of the current monetary
     *     locale is used.
     * @param  string $sep   Group separator. Replaced with the empty string. If
     *     omitted omitted the 'mon_thousands_sep' value of the current monetary
     *     locale is used.
     * @return Amount
     */
    public static function createFromLocaleString($strAmount, $point = null, $sep = null)
    {
        assert('is_string($strAmount)');

        if (is_null($sep)) {
            $locale = localeconv();
            $sep = $locale['mon_thousands_sep'];
            if (is_null($point)) {
                $point = $locale['mon_decimal_point'];
            }
        }

        assert('is_string($point)');
        assert('is_string($sep)');

        $strAmount = str_replace($point, '.', $strAmount);
        $strAmount = str_replace($sep, '', $strAmount);

        return new static($strAmount);
    }

    /**
     * Create amount from signal string
     *
     * Signal strings does not contain a decimal digit separator. Instead the
     * last two digits are always considered decimals. For negative values the
     * last digit is converted to an alphabetic character according to schema:
     * 0 => å, 1 => J, 2 => K, ... 9 => R.
     * 
     * @param  string $strAmount
     * @return Amount
     * @throws InvalidAmountException If amount is not a valid signal string
     */
    public static function createFromSignalString($strAmount)
    {
        if (!preg_match("/^\d+(å|[JKLMNOPQR])?$/", $strAmount)) {
            throw new InvalidAmountException("Amount must be a valid singal string");
        }

        if (!is_numeric($strAmount)) {
            $strAmount = '-' . str_replace(
                self::$signals,
                array_keys(self::$signals),
                $strAmount
            );
        }

        return new static(
            preg_replace("/^(-?\d*)(\d\d)$/", "$1.$2", $strAmount, 1)
        );
    }

    /**
     * Get the raw stored amount
     *
     * @return string
     */
    public function getAmount()
    {
        return $this->amount;
    }

    /**
     * Get amount as string
     *
     * @param  int $precision Optional decimal precision
     * @return string
     */
    public function getString($precision = -1)
    {
        return bcadd(
            $this->getAmount(),
            '0.0',
            $precision >= 0 ? $precision : $this->getDefaultPrecision()
        );
    }

    /**
     * Get amount as string
     *
     * @return string
     */
    public function __tostring()
    {
        return $this->getString();
    }

    /**
     * Get amount as signal string
     *
     * Signal strings does not contain a decimal digit separator. Instead the
     * last two digits are always considered decimals. For negative values the
     * last digit is converted to an alphabetic character according to schema:
     * 0 => å, 1 => J, 2 => K, ... 9 => R.
     *
     * @return string
     */
    public function getSignalString()
    {
        if ($this->isNegative()) {
            $strAmount = $this->getAbsolute()->getString(2);
            $strAmount = substr($strAmount, 0, -1) . self::$signals[substr($strAmount, -1)];
        } else {
            $strAmount = $this->getString(2);
        }

        return str_replace('.', '', $strAmount);
    }

    /**
     * Locale aware format amount
     *
     * Note that amount is converted to a floating point number before
     * formatting takes place. This may lead to a loss of precision.
     *
     * @param  string $format Format string as accepted by money_format().
     *     Defaults to '%!n': national currency format without currency symbol.
     * @return string
     */
    public function format($format = '%!n')
    {
        assert('is_string($format)');
        return money_format($format, $this->getFloat());
    }

    /**
     * Get amount as integer
     *
     * Amount is evaluated using intval
     *
     * @return int
     */
    public function getInt()
    {
        return intval($this->getAmount());
    }

    /**
     * Get amount as float
     *
     * Note that amount internally is stored as a string. Converting to floating
     * point number may lead to a loss of precision.
     *
     * @param  int   $precision Optional decimal precision
     * @return float
     */
    public function getFloat($precision = -1)
    {
        return (float)round(
            floatval($this->getAmount()),
            $precision >= 0 ? $precision : $this->getDefaultPrecision()
        );
    }

    /**
     * Get new Amount with the value of $amount added to instance
     *
     * @param  Amount $amount
     * @return Amount
     */
    public function add(Amount $amount)
    {
        return new static(
            bcadd(
                $this->getAmount(),
                $amount->getAmount(),
                $this->getInternalPrecision()
            )
        );
    }

    /**
     * Get new Amount with the value of $amount subtracted from instance
     *
     * @param  Amount $amount
     * @return Amount
     */
    public function subtract(Amount $amount)
    {
        return new static(
            bcsub(
                $this->getAmount(),
                $amount->getAmount(),
                $this->getInternalPrecision()
            )
        );
    }

    /**
     * Get new Amount with the value of instance multiplied with $amount
     *
     * @param  Amount $amount
     * @return Amount
     */
    public function multiplyWith(Amount $amount)
    {
        return new static(
            bcmul(
                $this->getAmount(),
                $amount->getAmount(),
                $this->getInternalPrecision()
            )
        );
    }

    /**
     * Get new Amount with the value of instance divided by $amount
     *
     * @param  Amount $amount
     * @return Amount
     */
    public function divideBy(Amount $amount)
    {
        return new static(
            bcdiv(
                $this->getAmount(),
                $amount->getAmount(),
                $this->getInternalPrecision()
            )
        );
    }

    /**
     * Compare to amount
     *
     * @param  Amount $amount
     * @return int 0 if instance and $amount are equal, 1 if instance is larger, -1 otherwise.
     */
    public function compareTo(Amount $amount)
    {
        return bccomp(
            $this->getAmount(),
            $amount->getAmount(),
            $this->getInternalPrecision()
        );
    }

    /**
     * Check if instance equals amount
     *
     * @param  Amount $amount
     * @return bool
     */
    public function equals(Amount $amount)
    {
        return 0 == $this->compareTo($amount);
    }

    /**
     * Check if instance is less than amount
     *
     * @param  Amount $amount
     * @return bool
     */
    public function isLessThan(Amount $amount)
    {
        return -1 == $this->compareTo($amount);
    }

    /**
     * Check if instance is less than or equals amount
     *
     * @param  Amount $amount
     * @return bool
     */
    public function isLessThanOrEquals(Amount $amount)
    {
        return $this->isLessThan($amount) || $this->equals($amount);
    }

    /**
     * Check if instance is greater than amount
     *
     * @param  Amount $amount
     * @return bool
     */
    public function isGreaterThan(Amount $amount)
    {
        return 1 == $this->compareTo($amount);
    }

    /**
     * Check if instance is greater than or equals amount
     *
     * @param  Amount $amount
     * @return bool
     */
    public function isGreaterThanOrEquals(Amount $amount)
    {
        return $this->isGreaterThan($amount) || $this->equals($amount);
    }

    /**
     * Check if amount is zero
     *
     * @return bool
     */
    public function isZero()
    {
        return $this->equals(new Amount('0'));
    }

    /**
     * Check if amount is greater than zero
     *
     * @return bool
     */
    public function isPositive()
    {
        return $this->isGreaterThan(new Amount('0'));
    }

    /**
     * Check if amount is less than zero
     *
     * @return bool
     */
    public function isNegative()
    {
        return $this->isLessThan(new Amount('0'));
    }

    /**
     * Get new amount with sign inverted
     *
     * @return Amount
     */
    public function getInverted()
    {
        return $this->multiplyWith(new Amount('-1'));
    }

    /**
     * Get new amount with negative sign removed
     *
     * @return Amount
     */
    public function getAbsolute()
    {
        return $this->isNegative() ? $this->getInverted() : clone $this;
    }

    /**
     * Get the default display precision for this currency
     *
     * @return int
     */
    protected function getDefaultPrecision()
    {
        return 2;
    }

    /**
     * Get the internal precision used in computations
     *
     * @return int
     */
    protected function getInternalPrecision()
    {
        return 10;
    }
}
