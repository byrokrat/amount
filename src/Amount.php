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
     * It is important to note that computers internally use the binary floating
     * point format and cannot accurately represent a number like 0.1, 0.2 or
     * 0.3 at all. Using floating point numbers leads to a loss of precision.
     * For example `floor((0.1+0.7)*10)` will usually return 7 instead of the
     * expected 8, since the internal representation will be something like
     * 7.9999999999999991118....
     * 
     * For this reason floats should never ne used to store monetary data. This
     * method exists for rare situations when converting from native formats is
     * inevitable. Unless you know what you are doing it should NOT be used.
     *
     * @param  int|float $number
     * @param  int $precision Optional decimal precision used in calculation
     * @return Amount
     * @throws InvalidArgumentException If $number is not an integer or float
     */
    public static function createFromNumber($number, $precision = -1)
    {
        if (!is_int($number) && !is_float($number)) {
            throw new InvalidArgumentException(
                "createFromNumber() expects an integer or float, found: ".gettype($number)
            );
        }

        return new static(
            number_format(
                $number,
                $precision >= 0 ? $precision : self::getInternalPrecision(),
                '.',
                ''
            )
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
                array($point, $sep, '[~placeholder~]'),
                array('[~placeholder~]', '', '.'),
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
     * Get new Amount rounded to $precision number of decimal digit using $rounder
     *
     * @param  integer $precision
     * @param  Rounder $rounder
     * @return Amount
     */
    public function roundTo($precision = -1, Rounder $rounder = null)
    {
        $rounder = $rounder ?: $this->getDefaultRounder();
        return new static(
            $rounder->round(
                $this->getAmount(),
                $precision >= 0 ? $precision : $this->getDisplayPrecision()
            )
        );
    }

    /**
     * Get amount as string
     *
     * @param  integer $precision Optional decimal precision
     * @param  Rounder $rounder
     * @return string
     */
    public function getString($precision = -1, Rounder $rounder = null)
    {
        return bcadd(
            $this->roundTo($precision, $rounder)->getAmount(),
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
     * @param  Rounder $rounder
     * @return integer
     */
    public function getInt(Rounder $rounder = null)
    {
        return (int)$this->getFloat(0, $rounder);
    }

    /**
     * Get amount as float
     *
     * It is important to note that computers internally use the binary floating
     * point format and cannot accurately represent a number like 0.1, 0.2 or
     * 0.3 at all. Using floating point numbers leads to a loss of precision.
     * For example `floor((0.1+0.7)*10)` will usually return 7 instead of the
     * expected 8, since the internal representation will be something like
     * 7.9999999999999991118....
     * 
     * For this reason floats should never ne used to store monetary data. This
     * method exists for rare situations when converting to native formats is
     * inevitable. Unless you know what you are doing it should NOT be used.
     *
     * @param  integer $precision Optional decimal precision
     * @param  Rounder $rounder
     * @return float
     */
    public function getFloat($precision = -1, Rounder $rounder = null)
    {
        return floatval($this->getString($precision, $rounder));
    }

    /**
     * Get amount as signal string
     *
     * Signal strings does not contain a decimal digit separator. Instead the
     * last two digits are always considered decimals. For negative values the
     * last digit is converted to an alphabetic character according to schema:
     * 0 => å, 1 => J, 2 => K, ... 9 => R.
     *
     * @param  Rounder $rounder
     * @return string
     */
    public function getSignalString(Rounder $rounder = null)
    {
        if ($this->isNegative()) {
            $signalStr = $this->getAbsolute()->getString(2, $rounder);
            $signalStr = substr($signalStr, 0, -1) . self::$signals[substr($signalStr, -1)];
        } else {
            $signalStr = $this->getString(2, $rounder);
        }

        return str_replace('.', '', $signalStr);
    }

    /**
     * Get new Amount with the value of $amount added to instance
     *
     * @param  Amount $amount
     * @param  int $precision Optional decimal precision used in calculation
     * @return Amount
     */
    public function add(Amount $amount, $precision = -1)
    {
        return new static(
            bcadd(
                $this->getAmount(),
                $amount->getAmount(),
                $precision >= 0 ? $precision : $this->getInternalPrecision()
            )
        );
    }

    /**
     * Get new Amount with the value of $amount subtracted from instance
     *
     * @param  Amount $amount
     * @param  int $precision Optional decimal precision used in calculation
     * @return Amount
     */
    public function subtract(Amount $amount, $precision = -1)
    {
        return new static(
            bcsub(
                $this->getAmount(),
                $amount->getAmount(),
                $precision >= 0 ? $precision : $this->getInternalPrecision()
            )
        );
    }

    /**
     * Get new Amount with the value of instance multiplied with $amount
     *
     * @param  int|float|string|Amount $amount
     * @param  int $precision Optional decimal precision used in calculation
     * @return Amount
     */
    public function multiplyWith($amount, $precision = -1)
    {
        return new static(
            bcmul(
                $this->getAmount(),
                $this->castToString($amount),
                $precision >= 0 ? $precision : $this->getInternalPrecision()
            )
        );
    }

    /**
     * Get new Amount with the value of instance divided by $amount
     *
     * @param  int|float|string|Amount $amount
     * @param  int $precision Optional decimal precision used in calculation
     * @return Amount
     */
    public function divideBy($amount, $precision = -1)
    {
        return new static(
            bcdiv(
                $this->getAmount(),
                $this->castToString($amount),
                $precision >= 0 ? $precision : $this->getInternalPrecision()
            )
        );
    }

    /**
     * Compare to amount
     *
     * @param  Amount $amount
     * @param  int $precision Optional decimal precision used in calculation
     * @return int 0 if instance and $amount are equal, 1 if instance is larger, -1 otherwise.
     */
    public function compareTo(Amount $amount, $precision = -1)
    {
        return bccomp(
            $this->getAmount(),
            $amount->getAmount(),
            $precision >= 0 ? $precision : $this->getInternalPrecision()
        );
    }

    /**
     * Check if instance equals amount
     *
     * @param  Amount $amount
     * @param  int $precision Optional decimal precision used in calculation
     * @return bool
     */
    public function equals(Amount $amount, $precision = -1)
    {
        return 0 == $this->compareTo($amount, $precision);
    }

    /**
     * Check if instance is less than amount
     *
     * @param  Amount $amount
     * @param  int $precision Optional decimal precision used in calculation
     * @return bool
     */
    public function isLessThan(Amount $amount, $precision = -1)
    {
        return -1 == $this->compareTo($amount, $precision);
    }

    /**
     * Check if instance is less than or equals amount
     *
     * @param  Amount $amount
     * @param  int $precision Optional decimal precision used in calculation
     * @return bool
     */
    public function isLessThanOrEquals(Amount $amount, $precision = -1)
    {
        return $this->isLessThan($amount, $precision) || $this->equals($amount, $precision);
    }

    /**
     * Check if instance is greater than amount
     *
     * @param  Amount $amount
     * @param  int $precision Optional decimal precision used in calculation
     * @return bool
     */
    public function isGreaterThan(Amount $amount, $precision = -1)
    {
        return 1 == $this->compareTo($amount, $precision);
    }

    /**
     * Check if instance is greater than or equals amount
     *
     * @param  Amount $amount
     * @param  int $precision Optional decimal precision used in calculation
     * @return bool
     */
    public function isGreaterThanOrEquals(Amount $amount, $precision = -1)
    {
        return $this->isGreaterThan($amount, $precision) || $this->equals($amount, $precision);
    }

    /**
     * Check if amount is zero
     *
     * @param  int $precision Optional decimal precision used in calculation
     * @return bool
     */
    public function isZero($precision = -1)
    {
        return $this->equals(new static('0'), $precision);
    }

    /**
     * Check if amount is greater than zero
     *
     * @param  int $precision Optional decimal precision used in calculation
     * @return bool
     */
    public function isPositive($precision = -1)
    {
        return $this->isGreaterThan(new static('0'), $precision);
    }

    /**
     * Check if amount is less than zero
     *
     * @param  int $precision Optional decimal precision used in calculation
     * @return bool
     */
    public function isNegative($precision = -1)
    {
        return $this->isLessThan(new static('0'), $precision);
    }

    /**
     * Get new amount with sign inverted
     *
     * @return Amount
     */
    public function getInverted()
    {
        return $this->isNegative()
            ? $this->getAbsolute()
            : new static(
                '-'
                .str_replace('+', '', $this->getAmount())
            );
    }

    /**
     * Get new amount with negative sign removed
     *
     * @return Amount
     */
    public function getAbsolute()
    {
        return new static(str_replace('-', '', $this->getAmount()));
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
     * Get the default internal precision used in computations
     *
     * @return int
     */
    public static function getInternalPrecision()
    {
        return 10;
    }

    /**
     * Get default rounding strategy
     *
     * @return Rounder
     */
    public static function getDefaultRounder()
    {
        return new Rounder\RoundHalfUp;
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
