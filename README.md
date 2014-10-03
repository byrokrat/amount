# ledgr/amount

[![Latest Stable Version](https://poser.pugx.org/ledgr/amount/v/stable.png)](https://packagist.org/packages/ledgr/amount)
[![Build Status](https://travis-ci.org/ledgr/amount.svg)](https://travis-ci.org/ledgr/amount)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/ledgr/amount/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/ledgr/amount/?branch=master)

Value objects for monetary amounts.

> Install using [composer](http://getcomposer.org/). Exists as **ledgr/amount**
> in the packagist repository.

Features
--------
 * Immutable value object.
 * Using the [bcmath](http://php.net/manual/en/book.bc.php) extension for
   arbitrary floating point arithmetic precision.

Api
---
[`Amount`](/src/Amount.php) defines the following api:

 * __`__construct([string $amount]) : Amount`__ create new instance.
 * __`createFromNumber(int|float $number) : Amount`__ create from integer or floating
   point number.
 * __`createFromLocaleString(string $str [, string $point [, string $sep]]) : Amount`
   create from a localized formatted string.
 * __`createFromSignalString(string $str) : Amount`__ create from signal string.
 * __`getAmount() : string`__ get the raw stored amount.
 * __`getString([int $precision]) : string`__ get amount as string.
 * __`__tostring() : string`__ get amount as string.
 * __`format([string $format]) : string`__ get locale aware format.
 * __`getInt() : int`__ get amount as integer (WARNING: loss of precision).
 * __`getFloat([int $precision]) : float`__ get amount as float (WARNING: loss of
    precision).
 * __`getSignalString() : string`__ get amount as a signal string.
 * __`add(Amount $amount) : Amount`__ get new Amount with the value of $amount added.
 * __`subtract(Amount $amount) : Amount`__ get new Amount with the value of $amount subtracted.
 * __`multiplyWith(Amount $amount) : Amount`__ get new Amount with value multiplied with $amount.
 * __`divideBy(Amount $amount) : Amount`__ get new Amount with value divided by $amount.
 * __`compareTo(Amount $amount) : int`__ 0 if equals $amount, 1 if greater than amount, -1 otherwise.
 * __`equals(Amount $amount) : bool`__ check if equals amount.
 * __`isLessThan(Amount $amount) : bool`__ check if less than amount.
 * __`isLessThanOrEquals(Amount $amount) : bool`__ check if less than or equals amount.
 * __`isGreaterThan(Amount $amount) : bool`__ check if greater than amount.
 * __`isGreaterThanOrEquals(Amount $amount) : bool`__ check if greater than or equals amount.
 * __`isZero() : bool`__ check if amount is zero.
 * __`isPositive() : bool`__ check if amount is greater than zero.
 * __`isNegative() : bool`__ check if amount is less than zero.
 * __`getInverted() : Amount`__ get new amount with sign inverted.
 * __`getAbsolute() : Amount`__ get new amount with negative sign removed.

Usage
-----
```php
use ledgr\amount\Amount;
$amount = new Amount('100.5');
$amount->isGreaterThan(new Amount('50'));  // true
$amount->getString();                      // 100.50
```
