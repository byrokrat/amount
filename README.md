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

 * `**__construct**([string $amount]) : Amount` create new instance.
 * `**createFromNumber**(int|float $number) : Amount` create from integer or floating
   point number.
 * `**createFromLocaleString**(string $str [, string $point [, string $sep]]) : Amount`
   create from a localized formatted string.
 * `**createFromSignalString**(string $str) : Amount` create from signal string.
 * `**getAmount**() : string` get the raw stored amount.
 * `**getString**([int $precision]) : string` get amount as string.
 * `**__tostring**() : string` get amount as string.
 * `**format**([string $format]) : string` get locale aware format.
 * `**getInt**() : int` get amount as integer (WARNING: loss of precision).
 * `**getFloat**([int $precision]) : float` get amount as float (WARNING: loss of
    precision).
 * `**getSignalString**() : string` get amount as a signal string.
 * `**add**(Amount $amount) : Amount` get new Amount with the value of $amount added.
 * `**subtract**(Amount $amount) : Amount` get new Amount with the value of $amount subtracted.
 * `**multiplyWith**(Amount $amount) : Amount` get new Amount with value multiplied with $amount.
 * `**divideBy**(Amount $amount) : Amount` get new Amount with value divided by $amount.
 * `**compareTo**(Amount $amount) : int` 0 if equals $amount, 1 if greater than amount, -1 otherwise.
 * `**equals**(Amount $amount) : bool` check if equals amount.
 * `**isLessThan**(Amount $amount) : bool` check if less than amount.
 * `**isLessThanOrEquals**(Amount $amount) : bool` check if less than or equals amount.
 * `**isGreaterThan**(Amount $amount) : bool` check if greater than amount.
 * `**isGreaterThanOrEquals**(Amount $amount) : bool` check if greater than or equals amount.
 * `**isZero**() : bool` check if amount is zero.
 * `**isPositive**() : bool` check if amount is greater than zero.
 * `**isNegative**() : bool` check if amount is less than zero.
 * `**getInverted**() : Amount` get new amount with sign inverted.
 * `**getAbsolute**() : Amount` get new amount with negative sign removed.

Usage
-----
```php
use ledgr\amount\Amount;
$amount = new Amount('100.5');
$amount->isGreaterThan(new Amount('50'));  // true
$amount->getString();                      // 100.50
```
