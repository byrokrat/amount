<?php
namespace ledgr\amount;

class AmountTest extends \PHPUnit_Framework_TestCase
{
    public function assertAmount(Amount $amount, $str, $toStr, $float, $signal, $int)
    {
        $this->assertSame($str, $amount->getString(), 'string');
        $this->assertSame($toStr, (string)$amount, '__tostring');
        $this->assertSame($float, $amount->getFloat(), 'float');
        $this->assertSame($signal, $amount->getSignalString(), 'signal');
        $this->assertSame($int, $amount->getInt(), 'int');
    }

    /**
     * @dataProvider amountProvider
     */
    public function testAmounts($precision, $str, $toStr, $float, $signal, $int, $intSafe)
    {
        $amount = new Amount($str, $precision);
        $this->assertAmount($amount, $str, $toStr, $float, $signal, $int);

        $amount->setFloat($float);
        $this->assertAmount($amount, $str, $toStr, $float, $signal, $int);

        $amount->setSignalString($signal);
        $this->assertAmount($amount, $str, $toStr, $float, $signal, $int);

        if ($intSafe) {
            $amount->setInt($int);
            $this->assertAmount($amount, $str, $toStr, $float, $signal, $int);
        }
    }

    public function amountProvider()
    {
        return array(
            array(0, '100',     '100',     100.,    '10000', 100, true),
            array(1, '100.0',   '100.0',   100.0,   '10000', 100, true),
            array(2, '100.00',  '100.00',  100.00,  '10000', 100, true),
            array(3, '100.000', '100.000', 100.000, '10000', 100, true),

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

        $amount->setString('123.0');
        $this->assertSame("123.00", $amount->getString());

        $amount->setString('123.111');
        $this->assertSame("123.11", $amount->getString());

        $amount->setString('123.119');
        $this->assertSame(123.12, $amount->getFloat());
        $this->assertSame("123.11", $amount->getString());
        $this->assertSame("123.119", $amount->getString(3));

        $amount->setString('-123.141');
        $this->assertSame("-123.14", $amount->getString());

        $amount->setString('-123.149');
        $this->assertSame(-123.15, $amount->getFloat());
        $this->assertSame("-123.14", $amount->getString());
    }

    public function testAdd()
    {
        $amount = new Amount('100', 2);

        $amount->add(new Amount('50'));
        $this->assertSame('150.00', $amount->getString());

        $amount->add(new Amount('-100'));
        $this->assertSame('50.00', $amount->getString());

        $amount->add(new Amount('-100'));
        $this->assertSame('-50.00', $amount->getString());
    }

    public function testSubtract()
    {
        $amount = new Amount('99');
        $amount->subtract(new Amount('100.50'));
        $amount->setPrecision(2);
        $this->assertSame('-1.50', $amount->getString());
    }

    public function testMultiplyWith()
    {
        $amount = new Amount('10');
        $amount->multiplyWith(new Amount('10'));
        $amount->setPrecision(0);
        $this->assertSame('100', $amount->getString());
    }

    public function testDivideBy()
    {
        $amount = new Amount('10');
        $amount->divideBy(new Amount('10'));
        $amount->setPrecision(0);
        $this->assertSame('1', $amount->getString());
    }

    public function testInvert()
    {
        $amount = new Amount('50.50');
        $amount->invert();
        $amount->setPrecision(2);
        $this->assertSame('-50.50', $amount->getString());
    }

    public function testPrecision()
    {
        $amount = new Amount('35', 10);
        $amount->add(new Amount('-34.99'));
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

    public function testEqualsLesserGreaterThan()
    {
        $amount = new Amount('100');

        $this->assertTrue($amount->equals(new Amount('100')));
        $this->assertTrue($amount->isLesserThan(new Amount('150')));
        $this->assertTrue($amount->isGreaterThan(new Amount('50')));

        $this->assertFalse($amount->equals(new Amount('1000')));
        $this->assertFalse($amount->isLesserThan(new Amount('50')));
        $this->assertFalse($amount->isGreaterThan(new Amount('150')));
    }

    public function testSetEmptyString()
    {
        $amount = new Amount('');
        $this->assertTrue($amount->equals(new Amount('0.0')));
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
        $this->assertSame('10000.00', $amount->getRawString());
        $amount->setLocaleString('-10 000,00', ',', ' ');
        $this->assertSame('-10000.00', $amount->getRawString());
    }

    /**
     * @expectedException ledgr\amount\InvalidAmountException
     */
    public function testInvalidAmount()
    {
        new Amount(null);
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
        $amount = new Amount();
        $amount->setString('sdf');
    }

    /**
     * @expectedException ledgr\amount\InvalidAmountException
     */
    public function testInvalidSignal()
    {
        $amount = new Amount();
        $amount->setSignalString('Q123Q');
    }

    public function testHasValue()
    {
        $amount = new Amount('0');
        $this->assertFalse($amount->hasValue());

        $amount = new Amount('-10');
        $this->assertTrue($amount->hasValue());
    }

    public function testChaining()
    {
        $amount = new Amount('0');
        $this->assertSame(
            '10',
            $amount->subtract(new Amount('10'))->invert()->setPrecision(0)->getString()
        );
    }
}
