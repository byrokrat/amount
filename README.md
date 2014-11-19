# ledgr/amount

[![Packagist Version](https://img.shields.io/packagist/v/ledgr/amount.svg?style=flat-square)](https://packagist.org/packages/ledgr/amount)
[![Build Status](https://img.shields.io/travis/ledgr/amount/master.svg?style=flat-square)](https://travis-ci.org/ledgr/amount)
[![Quality Score](https://img.shields.io/scrutinizer/g/ledgr/amount.svg?style=flat-square)](https://scrutinizer-ci.com/g/ledgr/amount)
[![Dependency Status](https://img.shields.io/gemnasium/ledgr/amount.svg?style=flat-square)](https://gemnasium.com/ledgr/amount)

Value objects for monetary amounts.

> Install using **[composer](http://getcomposer.org/)**. Exists as
> **[ledgr/amount](https://packagist.org/packages/ledgr/amount)**
> in the **[packagist](https://packagist.org/)** repository.

# ledgr/amount

Features
--------
 * Immutable value object.
 * Using the [bcmath](http://php.net/manual/en/book.bc.php) extension for
   arbitrary floating point arithmetic precision.
 * Support for multiple rounding strategies
 * Support for the signal string format as used in the swedish direct debit system.

Api
---
[`Amount`](/src/Amount.php) defines the following api:

Method signature                                    | returns | description
:-------------------------------------------------- | :------ | :-------------------------------------------
**__construct(string $amount)**                     | Amount  | Create new instance
**getAmount()**                                     | string  | Get raw amount
**getString([[int $precision], Rounder $rounder])** | string  | Get amount as string
**__tostring()**                                    | string  | Get amount as string
**getInt([Rounder $rounder])**                      | integer | Get amount as integer (WARNING)
**getFloat([[int $precision], Rounder $rounder])**  | float   | Get amount as float (WARNING)
**getSignalString([Rounder $rounder])**             | string  | Get amount as a signal string
**add(Amount $amount)**                             | Amount  | Get new Amount with $amount added
**subtract(Amount $amount)**                        | Amount  | Get new Amount with $amount subtracted
**multiplyWith(mixed $amount)**                     | Amount  | Get new Amount multiplied with $amount
**divideBy(mixed $amount)**                         | Amount  | Get new Amount with value divided by $amount
**compareTo(Amount $amount)**                       | integer | 0 if equals, 1 if greater, -1 otherwise
**equals(Amount $amount)**                          | boolean | Check if equals amount
**isLessThan(Amount $amount)**                      | boolean | Check if less than amount
**isLessThanOrEquals(Amount $amount)**              | boolean | Check if less than or equals amount
**isGreaterThan(Amount $amount)**                   | boolean | Check if greater than amount
**isGreaterThanOrEquals(Amount $amount)**           | boolean | Check if greater than or equals amount
**isZero()**                                        | boolean | Check if amount is zero
**isPositive()**                                    | boolean | Check if amount is greater than zero
**isNegative()**                                    | boolean | Check if amount is less than zero
**getInverted()**                                   | Amount  | Get new amount with sign inverted
**getAbsolute()**                                   | Amount  | Get new amount with negative sign removed

Usage
-----
```php
use ledgr\amount\Amount;
$amount = new Amount('100.5');
$amount->isGreaterThan(new Amount('50'));  // true
$amount->getString();                      // 100.50
```

Creating Amounts from other formats
-----------------------------------

### Floating point numbers

`Amount` contains two convenience methods for working with floating point numbers.
`createFromNumber` can create an Amount object from a floating point number,
`getFloat` can convert an Amount object to a float. These methods should be used
with care.

It is important to note that computers internally use the binary floating
point format and cannot accurately represent a number like 0.1, 0.2 or
0.3 at all. Using floating point numbers leads to a loss of precision.
For example `floor((0.1+0.7)*10)` will usually return 7 instead of the
expected 8, since the internal representation will be something like
7.9999999999999991118....

For this reason floats should never ne used to store monetary data. These
methods exists for rare situations when converting to or from native formats is
inevitable. Unless you know what you are doing they should **NOT** be used.

For more information see the [php manual](http://php.net/manual/en/language.types.float.php)
or (What Every Programmer Should Know About Floating-Point Arithmetic)[http://floating-point-gui.de/].

### Formatted numbers

You can create Amounts from strings formatted with non-standard or locale dependent
decimal point and grouping characters using the static method **createFromFormat**.

```php
$formattedAmount = "2 000:50";
$amount = Amount::createFromFormat($formattedAmount, ":", " ");
echo $amount;  // outputs 2000.50
```

### Signal strings

The signal string format contans no decimal point and negative amounts are signaled
using a letter instead of the final digit. Create Amounts from signal strings
using the static method **createFromSignalString**.
