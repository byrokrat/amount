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
 * `setPrecision(int $precision) : Amount` sets the number of digits used in
    calculations and output.
 * `getPrecision() : int` gets the number of digits used in calculations and
    output.
 * `setInt(int $int) : Amount` loads amount from integer (WARNING: loss of
    precision).
 * `getInt() : int` gets amount as integer (WARNING: loss of precision).
 * `setFloat(float $float) : Amount` loads amount from float (WARNING: loss of
    precision).
 * `getFloat([int $precision]) : float` gets amount as float (WARNING: loss of
    precision).
 * `setString(string $str) : Amount` loads amount from string.
 * `getString([int $precision]) : string` gets amount as a non-locale aware
    string.
 * `__toString() : string` gets amount as non-locale aware string.
 * `getRawString() : string` gets the raw string representation.
 * `setLocaleString(string $str [, string $point [, string $sep]]) : Amount`
   loads amount from locale formatted string.
 * `format([string $format]) : string` gets locale aware format.
 * `isSignalString(string $str) : bool` check if $str is a valid signal string.
 * `setSignalString(string $str) : Amount` loads amount from signal string.
 * `getSignalString() : string` gets amount as signal string.
 * `add(Amount $amount) : Amount` add to amount.
 * `subtract(Amount $amount) : Amount` subtract from amount.
 * `multiplyWith(Amount $amount) : Amount` multiply with amount.
 * `divideBy(Amount $amount) : Amount` divide by amount.
 * `invert() : Amount` swap sign of amount.
 * `equals(Amount $amount) : bool` check if instance equals amount.
 * `isLesserThan(Amount $amount) : bool` check if instance is lesser than amount.
 * `isGreaterThan(Amount $amount) : bool` check if instance is greater than amount.
 * `hasValue() : bool` check if amount is non-cero.

Usage
-----
```php
use ledgr\amount\Amount;
$amount = new Amount('100.5');
$amount->isGreaterThan(new Amount('50'));  // true
$amount->getString();                      // 100.50
```
