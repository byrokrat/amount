<?php

namespace ledgr\amount;

class AmountTest extends \PHPUnit_Framework_TestCase
{
    public function amountFormatProvider()
    {
        return array(
            array(0, '100',     '100.00', 100.,    '10000', 100, true),
            array(1, '100.0',   '100.00', 100.0,   '10000', 100, true),
            array(2, '100.00',  '100.00', 100.00,  '10000', 100, true),
            array(3, '100.000', '100.00', 100.000, '10000', 100, true),

            array(2, '123.23', '123.23', 123.23, '12323', 123, false),
            array(2, '123.99', '123.99', 123.99, '12399', 123, false),

            array(2, '0.23', '0.23', 0.23, '023', 0, false),

            array(2, '-123.20', '-123.20', -123.20, '1232å', -123, false),
            array(2, '-123.21', '-123.21', -123.21, '1232J', -123, false),
            array(2, '-123.22', '-123.22', -123.22, '1232K', -123, false),
            array(2, '-123.23', '-123.23', -123.23, '1232L', -123, false),
            array(2, '-123.24', '-123.24', -123.24, '1232M', -123, false),
            array(2, '-123.25', '-123.25', -123.25, '1232N', -123, false),
            array(2, '-123.26', '-123.26', -123.26, '1232O', -123, false),
            array(2, '-123.27', '-123.27', -123.27, '1232P', -123, false),
            array(2, '-123.28', '-123.28', -123.28, '1232Q', -123, false),
            array(2, '-123.29', '-123.29', -123.29, '1232R', -123, false),
        );
    }

    public function assertAmountOutput(Amount $amount, $precision, $str, $toStr, $int, $float, $signal)
    {
        $this->assertSame($str, $amount->getString($precision), 'getString');
        $this->assertSame($toStr, (string)$amount, '__tostring');
        $this->assertSame($int, $amount->getInt(), 'getInt');
        $this->assertSame($float, $amount->getFloat($precision), 'getFloat');
        $this->assertSame($signal, $amount->getSignalString(), 'getSignalString');
    }

    /**
     * @dataProvider amountFormatProvider
     */
    public function testAmountFormats($precision, $str, $toStr, $float, $signal, $int, $intSafe)
    {
        $this->assertAmountOutput(new Amount($str), $precision, $str, $toStr, $int, $float, $signal);
        $this->assertAmountOutput(Amount::createFromNumber($float), $precision, $str, $toStr, $int, $float, $signal);
        $this->assertAmountOutput(Amount::createFromSignalString($signal), $precision, $str, $toStr, $int, $float, $signal);
        if ($intSafe) {
            $this->assertAmountOutput(Amount::createFromNumber($int), $precision, $str, $toStr, $int, $float, $signal);
        }
    }

    public function testInvalidAmountException()
    {
        $this->setExpectedException('ledgr\amount\InvalidAmountException');
        new Amount('sdf');
    }

    public function testCreateFromNumberException()
    {
        $this->setExpectedException('ledgr\amount\InvalidAmountException');
        Amount::createFromNumber(true);
    }

    public function testCreateFromSignalStringException()
    {
        $this->setExpectedException('ledgr\amount\InvalidAmountException');
        Amount::createFromSignalString('Q123Q');
    }

    public function testCreateFromLocaleString()
    {
        $this->assertSame(
            '10000.00',
            Amount::createFromLocaleString('10000.00')->getString(2)
        );
        $this->assertSame(
            '-10000.00',
            Amount::createFromLocaleString('-10 000,00', ',', ' ')->getString(2)
        );
    }

    public function testFormat()
    {
        $amount = new Amount('10000.5');
        $this->assertSame(
            '10000.50',
            $amount->format('%!^n')
        );
    }

    public function testRounding()
    {
        $amount = Amount::createFromNumber(123.0);
        $this->assertSame(123.00, $amount->getFloat(2));

        $amount = Amount::createFromNumber(123.111);
        $this->assertSame(123.11, $amount->getFloat(2));

        $amount = Amount::createFromNumber(123.119);
        $this->assertSame(123.12, $amount->getFloat(2));
        $this->assertSame(123.119, $amount->getFloat(3));
        $this->assertSame("123.11", $amount->getString(2));

        $amount = Amount::createFromNumber(-123.111);
        $this->assertSame(-123.11, $amount->getFloat(2));

        $amount = Amount::createFromNumber(-123.119);
        $this->assertSame(-123.12, $amount->getFloat(2));
        $this->assertSame("-123.11", $amount->getString(2));

        $amount = new Amount('123.0');
        $this->assertSame("123.00", $amount->getString(2));

        $amount = new Amount('123.111');
        $this->assertSame("123.11", $amount->getString(2));

        $amount = new Amount('123.119');
        $this->assertSame(123.12, $amount->getFloat(2));
        $this->assertSame("123.11", $amount->getString(2));
        $this->assertSame("123.119", $amount->getString(3));

        $amount = new Amount('-123.141');
        $this->assertSame("-123.14", $amount->getString(2));

        $amount = new Amount('-123.149');
        $this->assertSame(-123.15, $amount->getFloat(2));
        $this->assertSame("-123.14", $amount->getString(2));

        $amount1 = new Amount('1');
        $amount = $amount1->divideBy(new Amount('7'));
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
}
