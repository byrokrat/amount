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
     * @var int The number of decimal digits to use
     */
    private $precision;

    /**
     * @var array Substitution map for signal strings
     */
    private static $signals = array(
        '0' => 'å',
        '1' => 'J',
        '2' => 'K',
        '3' => 'L',
        '4' => 'M',
        '5' => 'N',
        '6' => 'O',
        '7' => 'P',
        '8' => 'Q',
        '9' => 'R',
    );

    /**
     * Constructor
     *
     * @param string $amount
     * @param int    $precision The number of decimal digits used in calculations
     */
    public function __construct($amount = '0', $precision = null)
    {
        if (!is_string($amount) || !is_numeric($amount)) {
            throw new InvalidAmountException("Amount must be a numerical string");
        }

        $this->amount = $amount;

        if (is_int($precision)) {
            $this->precision = abs($precision);
        }
    }

    /**
     * Create amount from integer or floating point number
     *
     * Note that amount internally is stored as a string. Converting number to
     * string may involve rounding and lead to a loss of precision.
     *
     * @param  int|float $number
     * @param  int       $precision The number of decimal digits used in calculations
     * @return Amount
     * @throws InvalidAmountException If $int is not an integer
     */
    public static function createFromNumber($number, $precision = null)
    {
        if (!is_int($number) && !is_float($number)) {
            throw new InvalidAmountException(
                "createFromNumber() expects an integer or a floating point number"
            );
        }
        return new static(sprintf('%F', $number), $precision);
    }

    /**
     * Create amount from a localized formatted string
     *
     * @param  string $str
     * @param  int    $precision The number of decimal digits used in calculations
     * @param  string $point Decimal point character. Replaced with '.' If
     *     omitted omitted the 'mon_decimal_point' value of the current monetary
     *     locale is used.
     * @param  string $sep   Group separator. Replaced with the empty string. If
     *     omitted omitted the 'mon_thousands_sep' value of the current monetary
     *     locale is used.
     * @return Amount
     */
    public static function createFromLocaleString($str, $precision = null, $point = null, $sep = null)
    {
        assert('is_string($str)');

        if (is_null($sep)) {
            $locale = localeconv();
            $sep = $locale['mon_thousands_sep'];
            if (is_null($point)) {
                $point = $locale['mon_decimal_point'];
            }
        }

        assert('is_string($point)');
        assert('is_string($sep)');

        $str = str_replace($point, '.', $str);
        $str = str_replace($sep, '', $str);

        return new static($str, $precision);
    }

    /**
     * Create amount from signal string
     *
     * Signal strings does not contain a decimal digit separator. Instead the
     * last two digits are always considered decimals. For negative values the
     * last digit is converted to an alphabetic character according to schema:
     *  0 => å, 1 => J, 2 => K, ... 9 => R.
     * 
     * @param  string $str
     * @param  int    $precision The number of decimal digits used in calculations
     * @return Amount
     * @throws InvalidAmountException If amount is not a valid signal string
     */
    public static function createFromSignalString($str, $precision = null)
    {
        if (!preg_match("/^\d+(å|[JKLMNOPQR])?$/", $str)) {
            throw new InvalidAmountException("Amount must be a valid singal string");
        }

        if (!is_numeric($str)) {
            $str = str_replace(
                self::$signals,
                array_keys(self::$signals),
                $str
            );
            $str = "-$str";
        }
        $str = preg_replace("/^(-?\d*)(\d\d)$/", "$1.$2", $str, 1);

        return new static($str, $precision);
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
     * Get amount as a non-locale aware string
     *
     * @param  int $precision The number of decimal digits returned, defaults to loaded value
     * @return string
     */
    public function getString($precision = null)
    {
        return bcadd($this->getAmount(), '0.0', $this->getPrecision($precision));
    }

    /**
     * Get amount as a non-locale aware string
     *
     * @return string
     */
    public function __toString()
    {
        return $this->getString();
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
     * @param  int   $precision Decimal precision. Defaults to loaded value.
     * @return float
     */
    public function getFloat($precision = null)
    {
        return (float)round(floatval($this->getAmount()), $this->getPrecision($precision));
    }

    /**
     * Get amount as signal string
     *
     * Signal strings does not contain a decimal digit separator. Instead the
     * last two digits are always considered decimals. For negative values the
     * last digit is converted to an alphabetic character. See
     * createFromSignalString() for more information.
     *
     * @return string
     */
    public function getSignalString()
    {
        $arAmount = str_split($this->getString(2));

        // Convert negative values
        if ($arAmount[0] == '-') {
            // Shift off sign
            array_shift($arAmount);
            // Set singal character
            $last = count($arAmount) -1;
            $arAmount[$last] = self::$signals[$arAmount[$last]];
        }

        // Remove decimal digit separator
        return str_replace('.', '', implode('', $arAmount));
    }

    /**
     * Get the number of decimal digits used in calculations and output
     *
     * If no precision is specified the 'frac_digits' value of the current
     * monetary locale is used (see localeconv() in the PHP documentation).
     *
     * If the monetary locale is 'C' a precision of 2 is used.
     *
     * @param  int $precision Decimal precision. Defaults to loaded value.
     * @return int
     */
    public function getPrecision($precision = null)
    {
        if (is_int($precision)) {
            return abs($precision);
        }

        if (!isset($this->precision)) {
            $info = localeconv();

            if ('C' == setlocale(LC_MONETARY, 0)) {
                $info['frac_digits'] = 2;
            }

            $this->precision = $info['frac_digits'];
        }

        return $this->precision;
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
                $this->getPrecision()
            ),
            $this->getPrecision()
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
                $this->getPrecision()
            ),
            $this->getPrecision()
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
                $this->getPrecision()
            ),
            $this->getPrecision()
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
                $this->getPrecision()
            ),
            $this->getPrecision()
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
            $this->getPrecision()
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
}
