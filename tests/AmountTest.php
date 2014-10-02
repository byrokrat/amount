<?php
namespace ledgr\amount;

class AmountTest extends \PHPUnit_Framework_TestCase
{
    public function assertAmount(Amount $amount, $str, $int, $float, $signal)
    {
        $this->assertSame($str,    $amount->getString(),       'getString');
        $this->assertSame($str,    (string)$amount,            '__tostring');
        $this->assertSame($int,    $amount->getInt(),          'getInt');
        $this->assertSame($float,  $amount->getFloat(),        'getFloat');
        $this->assertSame($signal, $amount->getSignalString(), 'getSignalString');
    }

    /**
     * @dataProvider amountProvider
     */
    public function testAmounts($precision, $str, $float, $signal, $int, $intSafe)
    {
        $amount = new Amount($str, $precision);
        $this->assertAmount($amount, $str, $int, $float, $signal);

        $amount->setFloat($float);
        $this->assertAmount($amount, $str, $int, $float, $signal);

        $amount->setSignalString($signal);
        $this->assertAmount($amount, $str, $int, $float, $signal);

        if ($intSafe) {
            $amount->setInt($int);
            $this->assertAmount($amount, $str, $int, $float, $signal);
        }
    }

    public function amountProvider()
    {
        return array(
            array(0, '100',     100.,    '10000', 100, true),
            array(1, '100.0',   100.0,   '10000', 100, true),
            array(2, '100.00',  100.00,  '10000', 100, true),
            array(3, '100.000', 100.000, '10000', 100, true),

            array(2, '123.23', 123.23, '12323', 123, false),
            array(2, '123.99', 123.99, '12399', 123, false),

            array(2, '0.23', 0.23, '023', 0, false),

            array(2, '-123.20', -123.20, '1232å', -123, false),
            array(2, '-123.21', -123.21, '1232J', -123, false),
            array(2, '-123.22', -123.22, '1232K', -123, false),
            array(2, '-123.23', -123.23, '1232L', -123, false),
            array(2, '-123.24', -123.24, '1232M', -123, false),
            array(2, '-123.25', -123.25, '1232N', -123, false),
            array(2, '-123.26', -123.26, '1232O', -123, false),
            array(2, '-123.27', -123.27, '1232P', -123, false),
            array(2, '-123.28', -123.28, '1232Q', -123, false),
            array(2, '-123.29', -123.29, '1232R', -123, false),
        );
    }

    public function testFloatRounding()
    {
        $amount = new Amount('0', 2);

        $amount->setFloat(123.0);
        $this->assertSame(123.00, $amount->getFloat());

        $amount->setFloat(123.111);
        $this->assertSame(123.11, $amount->getFloat());

        $amount->setFloat(123.119);
        $this->assertSame(123.12, $amount->getFloat());
        $this->assertSame(123.119, $amount->getFloat(3));
        $this->assertSame("123.11", $amount->getString());

        $amount->setFloat(-123.111);
        $this->assertSame(-123.11, $amount->getFloat());

        $amount->setFloat(-123.119);
        $this->assertSame(-123.12, $amount->getFloat());
        $this->assertSame("-123.11", $amount->getString());
    }

    public function testStringRounding()
    {
        $amount = new Amount('0', 2);

        $amount = new Amount('123.0', 2);
        $this->assertSame("123.00", $amount->getString());

        $amount = new Amount('123.111', 2);
        $this->assertSame("123.11", $amount->getString());

        $amount = new Amount('123.119', 2);
        $this->assertSame(123.12, $amount->getFloat());
        $this->assertSame("123.11", $amount->getString());
        $this->assertSame("123.119", $amount->getString(3));

        $amount = new Amount('-123.141', 2);
        $this->assertSame("-123.14", $amount->getString());

        $amount = new Amount('-123.149', 2);
        $this->assertSame(-123.15, $amount->getFloat());
        $this->assertSame("-123.14", $amount->getString());
    }

    public function testPrecision()
    {
        $amount = new Amount('35', 10);
        $amount = $amount->add(new Amount('-34.99'));
        $this->assertSame('0.0100000000', $amount->getString());
    }

    public function testGetPrecision()
    {
        $amount = new Amount();
        $amount->setPrecision(10);
        $this->assertSame(10, $amount->getPrecision());

        setlocale(LC_MONETARY, 'C');
        $amount = new Amount();
        $this->assertSame(2, $amount->getPrecision());

        $this->assertSame(100, $amount->getPrecision(-100));
    }

    public function testFormat()
    {
        $amount = new Amount('10000.5', 2);
        $this->assertSame('10000.50', $amount->format('%!^n'));
    }

    public function testSetLocaleString()
    {
        $amount = new Amount('0', 2);
        $amount->setLocaleString('10000.00');
        $this->assertSame('10000.00', $amount->getAmount());
        $amount->setLocaleString('-10 000,00', ',', ' ');
        $this->assertSame('-10000.00', $amount->getAmount());
    }

    /**
     * @expectedException ledgr\amount\InvalidAmountException
     */
    public function testInvalidAmount()
    {
        new Amount(true);
    }

    /**
     * @expectedException ledgr\amount\InvalidAmountException
     */
    public function testInvalidFloat()
    {
        $amount = new Amount();
        $amount->setFloat(1);
    }

    /**
     * @expectedException ledgr\amount\InvalidAmountException
     */
    public function testInvalidInt()
    {
        $amount = new Amount();
        $amount->setInt(1.0);
    }

    /**
     * @expectedException ledgr\amount\InvalidAmountException
     */
    public function testInvalidString()
    {
        $amount = new Amount('sdf');
    }

    /**
     * @expectedException ledgr\amount\InvalidAmountException
     */
    public function testInvalidSignal()
    {
        $amount = new Amount();
        $amount->setSignalString('Q123Q');
    }

    /*public function testChaining()
    {
        $amount = new Amount('0');
        $this->assertSame(
            '10',
            $amount->subtract(new Amount('10'))->getInverted()->setPrecision(0)->getString()
        );
    }*/

    public function testAdd()
    {
        $amount100 = new Amount('100', 0);
        $amount150 = $amount100->add(new Amount('50'));
        $this->assertSame('100', $amount100->getAmount());
        $this->assertSame('150', $amount150->getAmount());
    }

    public function testSubtract()
    {
        $amount100 = new Amount('100', 0);
        $amount50 = $amount100->subtract(new Amount('50'));
        $this->assertSame('100', $amount100->getAmount());
        $this->assertSame('50', $amount50->getAmount());
    }

    public function testMultiplyWith()
    {
        $amount10 = new Amount('10', 0);
        $amount100 = $amount10->multiplyWith(new Amount('10'));
        $this->assertSame('10', $amount10->getAmount());
        $this->assertSame('100', $amount100->getAmount());
    }

    public function testDivideBy()
    {
        $amount100 = new Amount('100', 0);
        $amount10 = $amount100->divideBy(new Amount('10'));
        $this->assertSame('100', $amount100->getAmount());
        $this->assertSame('10', $amount10->getAmount());
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
