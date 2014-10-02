# ledgr/amount

[![Latest Stable Version](https://poser.pugx.org/ledgr/amount/v/stable.png)](https://packagist.org/packages/ledgr/amount)
[![Build Status](https://travis-ci.org/ledgr/amount.svg)](https://travis-ci.org/ledgr/amount)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/ledgr/amount/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/ledgr/amount/?branch=master)

Handle monetary amounts using bcmath for arithmetic precision.

> Install using [composer](http://getcomposer.org/). Exists as **ledgr/amount** in
> the packagist repository.

Api
---
[`Amount`](/src/Amount.php) defines the following api:

 * `__construct([string $amount [, int $precision]]) : Amount` creates a new
    instance.
 * `getAmount() : string` gets the raw stored amount.
 * `getString([int $precision]) : string` gets amount as a non-locale aware
    string.
 * `__toString() : string` gets amount as non-locale aware string.
 * `getInt() : int` gets amount as integer (WARNING: loss of precision).
 * `getFloat([int $precision]) : float` gets amount as float (WARNING: loss of
    precision).
 * `getSignalString() : string` gets amount as a signal string.
 * `setPrecision(int $precision) : Amount` sets the number of digits used in
    calculations and output.
 * `getPrecision() : int` gets the number of digits used in calculations and
    output.
 * `setInt(int $int) : Amount` loads amount from integer (WARNING: loss of
    precision).
 * `setFloat(float $float) : Amount` loads amount from float (WARNING: loss of
    precision).
 * `setLocaleString(string $str [, string $point [, string $sep]]) : Amount`
   loads amount from locale formatted string.
 * `format([string $format]) : string` gets locale aware format.
 * `setSignalString(string $str) : Amount` loads amount from signal string.
 * `add(Amount $amount) : Amount` gets a new Amount with the value of $amount
   added to instance.
 * `subtract(Amount $amount) : Amount` gets a new Amount with the value of
   $amount subtracted from instance.
 * `multiplyWith(Amount $amount) : Amount` gets a new Amount with the value of
   instance multiplied with $amount.
 * `divideBy(Amount $amount) : Amount` gets a new Amount with the value of
   instance divided by $amount.
 * `compareTo(Amount $amount) : int` returns 0 if instance and $amount are equal,
   1 if instance is larger, -1 otherwise.
 * `equals(Amount $amount) : bool` checks if instance equals amount.
 * `isLessThan(Amount $amount) : bool` checks if instance is less than amount.
 * `isLessThanOrEquals(Amount $amount) : bool` checks if instance is less than or equals amount.
 * `isGreaterThan(Amount $amount) : bool` checks if instance is greater than amount.
 * `isGreaterThanOrEquals(Amount $amount) : bool` checks if instance is greater than or equals amount.
 * `isZero() : bool` checks if amount is zero.
 * `isPositive() : bool` checks if amount is greater than zero.
 * `isNegative() : bool` checks if amount is less than zero.
 * `getInverted() : Amount` gets new amount with sign inverted.
 * `getAbsolute() : Amount` gets new amount with negative sign removed.

Usage
-----
```php
use ledgr\amount\Amount;
$amount = new Amount('100.5');
$amount->isGreaterThan(new Amount('50'));  // true
$amount->getString();                      // 100.50
```
