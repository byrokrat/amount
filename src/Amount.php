<?php

declare(strict_types = 1);

namespace byrokrat\amount;

/**
 * Value class for working with and representing monetary amounts
 *
 * Uses the bcmath extension for arbitrary floating point arithmetic precision
 */
class Amount
{
    /**
     * @var string
     */
    private $amount;

    /**
     * @var array Substitution map for signal strings
     */
    private static $signals = [
        '0'=>'å', '1'=>'J', '2'=>'K', '3'=>'L', '4'=>'M', '5'=>'N', '6'=>'O', '7'=>'P', '8'=>'Q', '9'=>'R'
    ];

    /**
     * Create amount from numerical string
     *
     * @throws InvalidArgumentException If $amount is not valid
     */
    public function __construct(string $amount)
    {
        if (!preg_match("/^[+-]?\d*\.?\d*$/", $amount)) {
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
     * @throws InvalidArgumentException If $number is not an integer or float
     */
    public static function createFromNumber($number, int $precision = -1): Amount
    {
        if (!is_int($number) && !is_float($number)) {
            throw new InvalidArgumentException(
                "createFromNumber() expects an integer or float, found: " . gettype($number)
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
     */
    public static function createFromFormat(string $amount, string $point = '.', string $sep = ''): Amount
    {
        return new static(
            str_replace(
                [$point, $sep, '[~placeholder~]'],
                ['[~placeholder~]', '', '.'],
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
     * @throws InvalidArgumentException If $signalStr is not a valid signal string
     */
    public static function createFromSignalString(string $signalStr): Amount
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
     */
    public function getAmount(): string
    {
        return $this->amount;
    }

    /**
     * Get new Amount rounded to $precision number of decimal digit using $rounder
     */
    public function roundTo(int $precision = -1, Rounder $rounder = null): Amount
    {
        return new static(
            ($rounder ?: $this->getDefaultRounder())->round(
                $this->getAmount(),
                $precision >= 0 ? $precision : $this->getDisplayPrecision()
            )
        );
    }

    /**
     * Get amount as string
     */
    public function getString(int $precision = -1, Rounder $rounder = null): string
    {
        return bcadd(
            $this->roundTo($precision, $rounder)->getAmount(),
            '0.0',
            $precision >= 0 ? $precision : $this->getDisplayPrecision()
        );
    }

    /**
     * Get amount as string
     */
    public function __tostring(): string
    {
        return $this->getString();
    }

    /**
     * Get amount as integer
     */
    public function getInt(Rounder $rounder = null): int
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
     */
    public function getFloat(int $precision = -1, Rounder $rounder = null): float
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
     */
    public function getSignalString(Rounder $rounder = null): string
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
     */
    public function add(Amount $amount, int $precision = -1): Amount
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
     */
    public function subtract(Amount $amount, int $precision = -1): Amount
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
     * @param int|float|string|Amount $amount
     */
    public function multiplyWith($amount, int $precision = -1): Amount
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
     * @param int|float|string|Amount $amount
     */
    public function divideBy($amount, int $precision = -1): Amount
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
     * @return int 0 if instance and $amount are equal, 1 if instance is larger, -1 otherwise.
     */
    public function compareTo(Amount $amount, int $precision = -1): int
    {
        return bccomp(
            $this->getAmount(),
            $amount->getAmount(),
            $precision >= 0 ? $precision : $this->getInternalPrecision()
        );
    }

    /**
     * Check if instance equals amount
     */
    public function equals(Amount $amount, int $precision = -1): bool
    {
        return 0 == $this->compareTo($amount, $precision);
    }

    /**
     * Check if instance is less than amount
     */
    public function isLessThan(Amount $amount, int $precision = -1): bool
    {
        return -1 == $this->compareTo($amount, $precision);
    }

    /**
     * Check if instance is less than or equals amount
     */
    public function isLessThanOrEquals(Amount $amount, int $precision = -1): bool
    {
        return $this->isLessThan($amount, $precision) || $this->equals($amount, $precision);
    }

    /**
     * Check if instance is greater than amount
     */
    public function isGreaterThan(Amount $amount, int $precision = -1): bool
    {
        return 1 == $this->compareTo($amount, $precision);
    }

    /**
     * Check if instance is greater than or equals amount
     */
    public function isGreaterThanOrEquals(Amount $amount, int $precision = -1): bool
    {
        return $this->isGreaterThan($amount, $precision) || $this->equals($amount, $precision);
    }

    /**
     * Check if amount is zero
     */
    public function isZero(int $precision = -1): bool
    {
        return $this->equals(new static('0'), $precision);
    }

    /**
     * Check if amount is greater than zero
     */
    public function isPositive(int $precision = -1): bool
    {
        return $this->isGreaterThan(new static('0'), $precision);
    }

    /**
     * Check if amount is less than zero
     */
    public function isNegative(int $precision = -1): bool
    {
        return $this->isLessThan(new static('0'), $precision);
    }

    /**
     * Get new Amount with sign inverted
     */
    public function getInverted(): Amount
    {
        return $this->isNegative() ? $this->getAbsolute() : new static('-' . str_replace('+', '', $this->getAmount()));
    }

    /**
     * Get new Amount with negative sign removed
     */
    public function getAbsolute(): Amount
    {
        return new static(str_replace('-', '', $this->getAmount()));
    }

    /**
     * Allocate amount based on a list of ratios
     *
     * @param  int[]|float[] $ratios List of ratios
     * @param  int $precision Optional decimal precision used in calculation
     * @return Amount[] The allocated amounts
     */
    public function allocate(array $ratios, int $precision = -1): array
    {
        $remainder = clone $this;
        $results = [];
        $total = array_sum($ratios);
        $precision = $precision >= 0 ? $precision : $this->getDisplayPrecision();
        $unit = new static(bcdiv('1', '1' . str_repeat('0', $precision), $precision));

        foreach ($ratios as $ratio) {
            $share = $this->multiplyWith($ratio)->divideBy($total)->roundTo($precision, new Rounder\RoundDown);
            $results[] = $share;
            $remainder = $remainder->subtract($share);
        }

        for ($i = 0; $remainder->isGreaterThanOrEquals($unit) > 0; $i++) {
            $results[$i] = $results[$i]->add($unit);
            $remainder = $remainder->subtract($unit);
        }

        return $results;
    }


    /**
     * Get the default display precision
     */
    public static function getDisplayPrecision(): int
    {
        return 2;
    }

    /**
     * Get the default internal precision used in computations
     */
    public static function getInternalPrecision(): int
    {
        return 10;
    }

    /**
     * Get default rounding strategy
     */
    public static function getDefaultRounder(): Rounder
    {
        return new Rounder\RoundHalfUp;
    }

    /**
     * Get a numerical string from input
     *
     * @param  int|float|string|Amount $amount
     * @throws InvalidArgumentException If $amount is does not evaluate to a numberical string
     */
    private function castToString($amount): string
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
