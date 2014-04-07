<?php
namespace ledgr\amount;

class AmountTest extends \PHPUnit_Framework_TestCase
{
    public function assertAmount(Amount $a, $str, $toStr, $float, $signal, $int)
    {
        $this->assertSame($str, $a->getString(), 'string');
        $this->assertSame($toStr, (string)$a, '__tostring');
        $this->assertSame($float, $a->getFloat(), 'float');
        $this->assertSame($signal, $a->getSignalString(), 'signal');
        $this->assertSame($int, $a->getInt(), 'int');
    }

    /**
     * @dataProvider amountProvider
     */
    public function testAmounts($precision, $str, $toStr, $float, $signal, $int, $intSafe)
    {
        $a = new Amount($str, $precision);
        $this->assertAmount($a, $str, $toStr, $float, $signal, $int);

        $a->setFloat($float);
        $this->assertAmount($a, $str, $toStr, $float, $signal, $int);

        $a->setSignalString($signal);
        $this->assertAmount($a, $str, $toStr, $float, $signal, $int);

        if ($intSafe) {
            $a->setInt($int);
            $this->assertAmount($a, $str, $toStr, $float, $signal, $int);
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
        $a = new Amount('0', 2);

        $a->setFloat(123.0);
        $this->assertSame(123.00, $a->getFloat());

        $a->setFloat(123.111);
        $this->assertSame(123.11, $a->getFloat());

        $a->setFloat(123.119);
        $this->assertSame(123.12, $a->getFloat());
        $this->assertSame(123.119, $a->getFloat(3));
        $this->assertSame("123.11", $a->getString());

        $a->setFloat(-123.111);
        $this->assertSame(-123.11, $a->getFloat());

        $a->setFloat(-123.119);
        $this->assertSame(-123.12, $a->getFloat());
        $this->assertSame("-123.11", $a->getString());
    }

    public function testStringRounding()
    {
        $a = new Amount('0', 2);

        $a->setString('123.0');
        $this->assertSame("123.00", $a->getString());

        $a->setString('123.111');
        $this->assertSame("123.11", $a->getString());

        $a->setString('123.119');
        $this->assertSame(123.12, $a->getFloat());
        $this->assertSame("123.11", $a->getString());
        $this->assertSame("123.119", $a->getString(3));

        $a->setString('-123.141');
        $this->assertSame("-123.14", $a->getString());

        $a->setString('-123.149');
        $this->assertSame(-123.15, $a->getFloat());
        $this->assertSame("-123.14", $a->getString());
    }

    public function testAdd()
    {
        $a = new Amount('100', 2);

        $a->add(new Amount('50'));
        $this->assertSame('150.00', $a->getString());

        $a->add(new Amount('-100'));
        $this->assertSame('50.00', $a->getString());

        $a->add(new Amount('-100'));
        $this->assertSame('-50.00', $a->getString());
    }

    public function testSubtract()
    {
        $a = new Amount('99');
        $a->subtract(new Amount('100.50'));
        $a->setPrecision(2);
        $this->assertSame('-1.50', $a->getString());
    }

    public function testMultiplyWith()
    {
        $a = new Amount('10');
        $a->multiplyWith(new Amount('10'));
        $a->setPrecision(0);
        $this->assertSame('100', $a->getString());
    }

    public function testDivideBy()
    {
        $a = new Amount('10');
        $a->divideBy(new Amount('10'));
        $a->setPrecision(0);
        $this->assertSame('1', $a->getString());
    }

    public function testInvert()
    {
        $a = new Amount('50.50');
        $a->invert();
        $a->setPrecision(2);
        $this->assertSame('-50.50', $a->getString());
    }

    public function testPrecision()
    {
        $a = new Amount('35', 10);
        $b = new Amount('-34.99');
        $a->add($b);
        $this->assertSame('0.0100000000', $a->getString());
    }

    public function testGetPrecision()
    {
        $a = new Amount();
        $a->setPrecision(10);
        $this->assertSame(10, $a->getPrecision());

        setlocale(LC_MONETARY, 'C');
        $a = new Amount();
        $this->assertSame(2, $a->getPrecision());

        $this->assertSame(100, $a->getPrecision(-100));
    }

    public function testEqualsLesserGreaterThan()
    {
        $a = new Amount('100');

        $this->assertTrue($a->equals(new Amount('100')));
        $this->assertTrue($a->isLesserThan(new Amount('150')));
        $this->assertTrue($a->isGreaterThan(new Amount('50')));

        $this->assertFalse($a->equals(new Amount('1000')));
        $this->assertFalse($a->isLesserThan(new Amount('50')));
        $this->assertFalse($a->isGreaterThan(new Amount('150')));
    }

    public function testSetEmptyString()
    {
        $a = new Amount('');
        $this->assertTrue($a->equals(new Amount('0.0')));
    }

    public function testFormat()
    {
        $a = new Amount('10000.5', 2);
        $this->assertSame('10000.50', $a->format('%!^n'));
    }

    public function testSetLocaleString()
    {
        $a = new Amount('0', 2);
        $a->setLocaleString('10000.00');
        $this->assertSame('10000.00', $a->getRawString());
        $a->setLocaleString('-10 000,00', ',', ' ');
        $this->assertSame('-10000.00', $a->getRawString());
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
        $a = new Amount();
        $a->setFloat(1);
    }

    /**
     * @expectedException ledgr\amount\InvalidAmountException
     */
    public function testInvalidInt()
    {
        $a = new Amount();
        $a->setInt(1.0);
    }

    /**
     * @expectedException ledgr\amount\InvalidAmountException
     */
    public function testInvalidString()
    {
        $a = new Amount();
        $a->setString('sdf');
    }

    /**
     * @expectedException ledgr\amount\InvalidAmountException
     */
    public function testInvalidSignal()
    {
        $a = new Amount();
        $a->setSignalString('Q123Q');
    }

    public function testHasValue()
    {
        $a = new Amount('0');
        $this->assertFalse($a->hasValue());

        $b = new Amount('-10');
        $this->assertTrue($b->hasValue());
    }

    public function testChaining()
    {
        $a = new Amount('0');
        $this->assertSame(
            '10',
            $a->subtract(new Amount('10'))->invert()->setPrecision(0)->getString()
        );
    }
}
