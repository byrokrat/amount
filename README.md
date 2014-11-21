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
 * [Currency](#working-with-currencies) support to prevent mixing currencies.
 * Simple interface for [defining new currencies](#creating-new-currencies).
 * Support for multiple [rounding](#rounding) strategies.
 * Support for [allocating](#allocating) amounts based on ratios.
 * Support for the [signal string](#signal-strings) format as used in the swedish direct debit system.


Api
---
[`Amount`](/src/Amount.php) defines the following api:

Method signature                                    | returns  | description
:-------------------------------------------------- | :------- | :------------------------------------------
**__construct(string $amount)**                     | Amount   | Create new instance
**getAmount()**                                     | string   | Get raw amount
**roundTo([int $precision, [Rounder $rounder]])**   | Amount   | Get new Amount rounded to $precision
**getString([int $precision, [Rounder $rounder]])** | string   | Get amount as string
**__tostring()**                                    | string   | Get amount as string
**getInt([Rounder $rounder])**                      | integer  | Get amount as integer (WARNING)
**getFloat([int $precision, [Rounder $rounder]])**  | float    | Get amount as float (WARNING)
**getSignalString([Rounder $rounder])**             | string   | Get amount as a signal string
**add(Amount $amount)**                             | Amount   | Get new Amount with $amount added
**subtract(Amount $amount)**                        | Amount   | Get new Amount with $amount subtracted
**multiplyWith(mixed $amount)**                     | Amount   | Get new Amount multiplied with $amount
**divideBy(mixed $amount)**                         | Amount   | Get new Amount divided by $amount
**compareTo(Amount $amount)**                       | integer  | 0 if equals, 1 if greater, -1 otherwise
**equals(Amount $amount)**                          | boolean  | Check if equals amount
**isLessThan(Amount $amount)**                      | boolean  | Check if less than amount
**isLessThanOrEquals(Amount $amount)**              | boolean  | Check if less than or equals amount
**isGreaterThan(Amount $amount)**                   | boolean  | Check if greater than amount
**isGreaterThanOrEquals(Amount $amount)**           | boolean  | Check if greater than or equals amount
**isZero()**                                        | boolean  | Check if amount is zero
**isPositive()**                                    | boolean  | Check if amount is greater than zero
**isNegative()**                                    | boolean  | Check if amount is less than zero
**getInverted()**                                   | Amount   | Get new amount with sign inverted
**getAbsolute()**                                   | Amount   | Get new amount with negative sign removed
**allocate(array $ratios, [int $precision])**       | Amount[] | Allocate amount based on list of ratios


Usage
-----
```php
use ledgr\amount\Amount;
$amount = new Amount('100.6');
$amount->isGreaterThan(new Amount('50'));  // true
$rounded = $amount->roundTo(0);            // round to 0 decimal digits
echo $rounded;                             // 101
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
or [What Every Programmer Should Know About Floating-Point Arithmetic](http://floating-point-gui.de/).

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


Working with currencies
-----------------------

The currency subsystem helps prevent bugs where values in different currencies are
mixed (for example added together). Currency objects subclass `Amount` and works in
the same way, with the added feature that they know their defined currency.

```php
use ledgr\amount\Currency\SEK;
use ledgr\amount\Currency\EUR;
$sek = new SEK('100');
$added = $sek->add(new EUR('1')); // throws an exception
$added = $sek->add(new SEK('1')); // works as intended
```

### Creating new currencies

Only the [`SEK`](/src/Currency/SEK.php) and [`EUR`](/src/Currency/EUR.php) currencies
are shipped with this package. Creating new currencies however is straight forward.
Simply subclass the [`Currency`](/src/Currency.php) class and define `getCurrencyCode()`.
See the [`currency subpackage`](/src/Currency/) for reference.

Additionaly you may override `getDisplayPrecision()`, `getInternalPrecision()` and
`getDefaultRounder()` inherited from [`Amount`](/src/Amount.php) to further define
your currency's behaviour.

### Exchanging

Exchanging currencies is supported using `createFromExchange`. Note that you must
supply the correct exchange rate.

```php
use ledgr\amount\Currency\SEK;
use ledgr\amount\Currency\EUR;
// One euro is exchanged into swedish kronas using the exchange rate 9.27198929
// resulting in the value of SEK 9.27198929
$sek = SEK::createFromExchange(new EUR('1'), '9.27198929');
```

### Formatting currencies

Currency objects can easily be formatted using php's built in `NumberFormatter`.

```php
// Create some amount of euros
$money = new EUR('1234567.89');

// Create a currency formatter with swedish formatting rules
$formatter = new NumberFormatter('sv_SE', NumberFormatter::CURRENCY);

// Format euros according to swedish standards, output 1 234 567:89 €
echo $formatter->formatCurrency($money->getFloat(), $money->getCurrencyCode());
```


Rounding
--------

A number of rounding strategies are supported. To implement your own see the
[Rounder](/src/Rounder.php) interface.

```php
namespace ledgr\amount;
$amount = new Amount('1.5');
echo $amount->roundTo(0, new Rounder\RoundUp);                // 2
echo $amount->roundTo(0, new Rounder\RoundDown);              // 1
echo $amount->roundTo(0, new Rounder\RoundTowardsZero);       // 1
echo $amount->roundTo(0, new Rounder\RoundAwayFromZero);      // 2
echo $amount->roundTo(0, new Rounder\RoundHalfUp);            // 2
echo $amount->roundTo(0, new Rounder\RoundHalfDown);          // 1
echo $amount->roundTo(0, new Rounder\RoundHalfTowardsZero);   // 1
echo $amount->roundTo(0, new Rounder\RoundHalfAwayFromZero);  // 2
echo $amount->roundTo(0, new Rounder\RoundHalfToEven);        // 2
echo $amount->roundTo(0, new Rounder\RoundHalfToOdd);         // 1
```

For more info on rounding strategies see [wikipedia](https://en.wikipedia.org/wiki/Rounding).


Allocating
----------

Allocating is the process of dividing an amount based on ratios in such a way that
the smallest unit is not divided (every currency has a smallest unit that is
non-dividable) but instead handed to the receiver next in line.

The ratios can be seen as (but does not have to be) percentages. A hundred units
can thous be divided to two receivers as

```php
use ledgr\amount\Amount;
$money = new Amount('100');
list($receiverA, $receiverB) = $money->allocate([30, 70]);
echo $receiverA;    // 30
echo $receiverB;    // 70
```

The strength of allocating becomes clear when we distribute a value that we are
not able to divide evenly. In this case the order of the receivers is significant.

```php
use ledgr\amount\Amount;
$money = new Amount('0.05');

list($receiverA, $receiverB) = $money->allocate([30, 70]);
echo $receiverA;    // 0.03
echo $receiverB;    // 0.02

list($receiverA, $receiverB) = $money->allocate([70, 30]);
echo $receiverA;    // 0.04
echo $receiverB;    // 0.01
```

In these examples the undividable unit used is `0.01`. This is the default behaviour.
Change it either by specifying the `$precision` parameter or by overriding
`getDisplayPrecision()` in your currency class.
