<?php

namespace ledgr\amount;

class AmountTest extends \PHPUnit_Framework_TestCase
{
    public function invalidStringsProvider()
    {
        return array(
            array(123),               // not a string
            array('alpha'),           // not numerical
            array((string)0.0000001), // converts to something like 1.0E-7
        );
    }

    /**
     * @dataProvider invalidStringsProvider
     */
    public function testInvalidStrings($argument)
    {
        $this->setExpectedException('ledgr\amount\InvalidArgumentException');
        new Amount($argument);
    }

    public function validStringsProvider()
    {
        return array(
            array('999', '999.00'),
            array('1.1', '1.10'),
            array('-123', '-123.00'),
            array('.01', '0.01'),
        );
    }

    /**
     * @dataProvider validStringsProvider
     */
    public function testCreatingFromString($string, $expected)
    {
        $amount = new Amount($string);
        $this->assertSame(
            $expected,
            $amount->getString(2)
        );
    }

    public function testRounding()
    {
        $amount = new Amount('123.0');
        $this->assertSame("123.00", $amount->getString(2));
        $this->assertSame(123.00, $amount->getFloat(2));
        $this->assertSame(123, $amount->getInt());

        $amount = new Amount('123.111');
        $this->assertSame("123.11", $amount->getString(2));
        $this->assertSame(123.11, $amount->getFloat(2));
        $this->assertSame(123, $amount->getInt());

        $amount = new Amount('123.119');
        $this->assertSame("123.11", $amount->getString(2));
        $this->assertSame("123.119", $amount->getString(3));
        $this->assertSame(123.12, $amount->getFloat(2));
        $this->assertSame(123.119, $amount->getFloat(3));
        $this->assertSame(123, $amount->getInt());

        $amount = new Amount('-123.119');
        $this->assertSame("-123.11", $amount->getString(2));
        $this->assertSame(-123.12, $amount->getFloat(2));
        $this->assertSame(-123, $amount->getInt());

        $amount = new Amount('-123.141');
        $this->assertSame("-123.14", $amount->getString(2));

        $amount = new Amount('-123.149');
        $this->assertSame("-123.14", $amount->getString(2));
        $this->assertSame(-123.15, $amount->getFloat(2));
        $this->assertSame(-123, $amount->getInt());

        $amount1 = new Amount('1');
        $amount = $amount1->divideBy(7);
        $this->assertSame('0.1428571428', $amount->getAmount());
        $this->assertSame('0.14', $amount->getString(2));
    }

    public function testAdd()
    {
        $amount100 = new Amount('100');
        $amount150 = $amount100->add(new Amount('50'));
        $this->assertSame('100', $amount100->getString(0));
        $this->assertSame('150', $amount150->getString(0));
    }

    public function testSubtract()
    {
        $amount100 = new Amount('100');
        $amount50 = $amount100->subtract(new Amount('50'));
        $this->assertSame('100', $amount100->getString(0));
        $this->assertSame('50', $amount50->getString(0));
    }

    public function testMultiplyWith()
    {
        $amount10 = new Amount('10');
        $amount100 = $amount10->multiplyWith(new Amount('10'));
        $this->assertSame('10', $amount10->getString(0));
        $this->assertSame('100', $amount100->getString(0));
    }

    public function testDivideBy()
    {
        $amount100 = new Amount('100');
        $amount10 = $amount100->divideBy(new Amount('10'));
        $this->assertSame('100', $amount100->getString(0));
        $this->assertSame('10', $amount10->getString(0));
    }

    public function testComparisons()
    {
        $amount100 = new Amount('100');
        $amount200 = new Amount('200');

        $this->assertTrue($amount100->equals($amount100));
        $this->assertTrue($amount100->isLessThan($amount200));
        $this->assertTrue($amount100->isLessThanOrEquals($amount200));
        $this->assertTrue($amount200->isGreaterThan($amount100));
        $this->assertTrue($amount100->isGreaterThanOrEquals($amount100));

        $this->assertFalse($amount100->equals($amount200));
        $this->assertFalse($amount200->isLessThan($amount100));
        $this->assertFalse($amount200->isLessThanOrEquals($amount100));
        $this->assertFalse($amount100->isGreaterThan($amount200));
        $this->assertFalse($amount100->isGreaterThanOrEquals($amount200));
    }

    public function testSigns()
    {
        $zero = new Amount('0');
        $this->assertTrue($zero->isZero());
        $this->assertFalse($zero->isPositive());
        $this->assertFalse($zero->isNegative());

        $ten = new Amount('10');
        $this->assertFalse($ten->isZero());
        $this->assertTrue($ten->isPositive());
        $this->assertFalse($ten->isNegative());

        $absoluteTen = $ten->getAbsolute();
        $this->assertNotSame($ten, $absoluteTen);
        $this->assertTrue($absoluteTen->isPositive());
        $this->assertFalse($absoluteTen->isNegative());

        $invertedTen = $ten->getInverted();
        $this->assertNotSame($ten, $invertedTen);
        $this->assertFalse($invertedTen->isPositive());
        $this->assertTrue($invertedTen->isNegative());

        $absoluteIinvertedTen = $invertedTen->getAbsolute();
        $this->assertNotSame($absoluteIinvertedTen, $invertedTen);
        $this->assertTrue($absoluteIinvertedTen->isPositive());
        $this->assertFalse($absoluteIinvertedTen->isNegative());
    }

    public function testBigIntegerSupport()
    {
        $this->assertSame(
            PHP_INT_MAX/2,
            Amount::createFromNumber(PHP_INT_MAX)->multiplyWith(2)->divideBy(4)->getFloat()
        );
    }

    public function numberProvider()
    {
        return array(
            array(100, '100.0000000000'),
            array(100.0, '100.0000000000'),
            array(100.00, '100.0000000000'),
            array(100.000, '100.0000000000'),
            array(123.23, '123.2300000000'),
            array(-123.99, '-123.9900000000'),
            array(0.23, '0.2300000000'),
            array(0.0000001, '0.0000001000'),
            array(1000000.0000001, '1000000.0000001000'),
            array(-1000000.0000001, '-1000000.0000001000'),
            array(999, '999.0000000000'),
            array(1.0E+22, '10000000000000000000000.0000000000'),
            array(1.000001E-4, '0.0001000001')
        );
    }

    /**
     * @dataProvider numberProvider
     */
    public function testCreateFromNumber($number, $expected)
    {
        $this->assertSame(
            $expected,
            Amount::createFromNumber($number)->getString(10)
        );
    }

    public function testInvalidNumber()
    {
        $this->setExpectedException('ledgr\amount\InvalidArgumentException');
        Amount::createFromNumber('string');
    }

    public function formattedAmountsProvider()
    {
        return array(
            array('-10 000,00', ',', ' ', '-10000.00'),
            array('1 234 567:89', ':', ' ', '1234567.89'),
            array('1,234,567.89', '.', ',', '1234567.89'),
            array('1.234.567,89', ',', '.', '1234567.89')
        );
    }

    /**
     * @dataProvider formattedAmountsProvider
     */
    public function testCreateFromFormat($formatted, $point, $sep, $expected)
    {
        $this->assertSame(
            $expected,
            Amount::createFromFormat($formatted, $point, $sep)->getString(2)
        );
    }

    public function signalStringsProvider()
    {
        return array(
            array('1230å', '-123.00'),
            array('1230J', '-123.01'),
            array('1230K', '-123.02'),
            array('1230L', '-123.03'),
            array('1230M', '-123.04'),
            array('1230N', '-123.05'),
            array('1230O', '-123.06'),
            array('1230P', '-123.07'),
            array('1230Q', '-123.08'),
            array('1230R', '-123.09'),
            array('12300', '123.00'),
        );
    }

    /**
     * @dataProvider signalStringsProvider
     */
    public function testCreateFromSignalString($signalStr, $expected)
    {
        $amount = Amount::createFromSignalString($signalStr);
        $this->assertSame(
            $expected,
            $amount->getString(2)
        );
        $this->assertSame(
            $signalStr,
            $amount->getSignalString()
        );
    }

    public function testInvalidSignalString()
    {
        $this->setExpectedException('ledgr\amount\InvalidArgumentException');
        Amount::createFromSignalString('Q123Q'); // not a valid signal string
    }

    public function testAutomaticStringConversion()
    {
        $this->assertSame(
            '100.00',
            (string)new Amount('100')
        );
    }
}
