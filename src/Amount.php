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
     * @throws InvalidArgumentException If $amount is not valid
     */
    public function __construct($amount)
    {
        if (!is_string($amount) || !preg_match("/^[+-]?\d*\.?\d*$/", $amount)) {
            throw new InvalidArgumentException("Constructor expects a numerical string");
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
     * @throws InvalidArgumentException If $number is not an integer or float
     */
    public static function createFromNumber($number)
    {
        if (!is_int($number) && !is_float($number)) {
            throw new InvalidArgumentException(
                "createFromNumber() expects an integer or float, found: ".gettype($number)
            );
        }

        return new static(
            number_format($number, static::getInternalPrecision(), '.', '')
        );
    }

    /**
     * Create amount from a formatted string
     *
     * @param  string $amount The formatted string to be parsed
     * @param  string $point  Decimal point character in formatted string
     * @param  string $sep    Group separator in formattet string
     * @return Amount
     */
    public static function createFromFormat($amount, $point = '.', $sep = '')
    {
        return new static(
            str_replace(
                array($point, $sep, '|'),
                array('|', '', '.'),
                $amount
            )
        );
    }

    /**
     * Create amount from signal string
     *
     * Signal strings does not contain a decimal digit separator. Instead the
     * last two digits are always considered decimals. For negative values the
     * last digit is converted to an alphabetic character according to schema:
     * 0 => å, 1 => J, 2 => K, ... 9 => R.
     * 
     * @param  string $signalStr
     * @return Amount
     * @throws InvalidArgumentException If $signalStr is not a valid signal string
     */
    public static function createFromSignalString($signalStr)
    {
        if (!preg_match("/^\d+(å|[JKLMNOPQR])?$/", $signalStr)) {
            throw new InvalidArgumentException("createFromSignalString() expects a valid signal string");
        }

        if (!is_numeric($signalStr)) {
            $signalStr = '-' . str_replace(
                self::$signals,
                array_keys(self::$signals),
                $signalStr
            );
        }

        return new static(
            preg_replace("/^(-?\d*)(\d\d)$/", "$1.$2", $signalStr, 1)
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
            $precision >= 0 ? $precision : $this->getDisplayPrecision()
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
     * Get amount as integer
     *
     * @return int
     */
    public function getInt()
    {
        return (int)$this->getFloat(0);
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
            $precision >= 0 ? $precision : $this->getDisplayPrecision()
        );
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
            $signalStr = $this->getAbsolute()->getString(2);
            $signalStr = substr($signalStr, 0, -1) . self::$signals[substr($signalStr, -1)];
        } else {
            $signalStr = $this->getString(2);
        }

        return str_replace('.', '', $signalStr);
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
     * @param  int|float|string|Amount $amount
     * @return Amount
     */
    public function multiplyWith($amount)
    {
        return new static(
            bcmul(
                $this->getAmount(),
                $this->castToString($amount),
                $this->getInternalPrecision()
            )
        );
    }

    /**
     * Get new Amount with the value of instance divided by $amount
     *
     * @param  int|float|string|Amount $amount
     * @return Amount
     */
    public function divideBy($amount)
    {
        return new static(
            bcdiv(
                $this->getAmount(),
                $this->castToString($amount),
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
     * Get the default display precision
     *
     * @return int
     */
    public static function getDisplayPrecision()
    {
        return 2;
    }

    /**
     * Get the internal precision used in computations
     *
     * @return int
     */
    public static function getInternalPrecision()
    {
        return 10;
    }

    /**
     * Get a numerical string from input
     *
     * @param  int|float|string|Amount $amount
     * @return string
     * @throws InvalidArgumentException If $amount is does not evaluate to a numberical string
     */
    private function castToString($amount)
    {
        switch (gettype($amount)) {
            case 'integer':
            case 'double':
                $amount = static::createFromNumber($amount);
                break;
            case 'string':
                $amount = new static($amount);
                break;
        }

        if (!$amount instanceof Amount) {
            throw new InvalidArgumentException("Supplied argument is not valid");
        }

        return $amount->getAmount();
    }
}
