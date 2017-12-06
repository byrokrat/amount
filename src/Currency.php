<?php

declare(strict_types = 1);

namespace byrokrat\amount;

/**
 * Abstract base currency class
 *
 * Create currency by extending this class. Prevents addition and other operations
 * on amounts from different currencies.
 */
abstract class Currency extends Amount
{
    /**
     * Create new currency object by exchange from foreign currency
     *
     * @param  Currency                $amount The amount to exchange
     * @param  int|float|string|Amount $rate   The exchange rate used
     */
    public static function createFromExchange(Currency $amount, $rate): Currency
    {
        return new static($amount->multiplyWith($rate)->getAmount());
    }

    /**
     * Get ISO-4217 currency name
     */
    abstract public function getCurrencyCode(): string;

    public function add(Amount $amount, int $precision = -1): Amount
    {
        return parent::add($this->validateCurrency($amount), $precision);
    }

    public function subtract(Amount $amount, int $precision = -1): Amount
    {
        return parent::subtract($this->validateCurrency($amount), $precision);
    }

    public function compareTo(Amount $amount, int $precision = -1): int
    {
        return parent::compareTo($this->validateCurrency($amount), $precision);
    }

    public function equals(Amount $amount, int $precision = -1): bool
    {
        return parent::equals($this->validateCurrency($amount), $precision);
    }

    public function isLessThan(Amount $amount, int $precision = -1): bool
    {
        return parent::isLessThan($this->validateCurrency($amount), $precision);
    }

    public function isLessThanOrEquals(Amount $amount, int $precision = -1): bool
    {
        return parent::isLessThanOrEquals($this->validateCurrency($amount), $precision);
    }

    public function isGreaterThan(Amount $amount, int $precision = -1): bool
    {
        return parent::isGreaterThan($this->validateCurrency($amount), $precision);
    }

    public function isGreaterThanOrEquals(Amount $amount, int $precision = -1): bool
    {
        return parent::isGreaterThanOrEquals($this->validateCurrency($amount), $precision);
    }

    /**
     * Validate that amount is in the expected currency
     *
     * @throws InvalidArgumentException If amount is in an unexpected currency
     */
    protected function validateCurrency(Amount $amount): Amount
    {
        if (!$amount instanceof static) {
            throw new InvalidArgumentException(
                "Currency " . get_class($this) . " expected, found " . get_class($amount)
            );
        }

        return $amount;
    }
}
