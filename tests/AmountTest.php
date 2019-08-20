<?php

declare(strict_types = 1);

namespace byrokrat\amount;

class AmountTest extends \PHPUnit\Framework\TestCase
{
    public function invalidStringsProvider()
    {
        return [
            ['alpha'],           // not numerical
            [(string)0.0000001], // converts to something like 1.0E-7
        ];
    }

    /**
     * @dataProvider invalidStringsProvider
     */
    public function testInvalidStrings($argument)
    {
        $this->expectException(InvalidArgumentException::CLASS);
        new Amount($argument);
    }

    public function validStringsProvider()
    {
        return [
            ['999', '999.00'],
            ['1.1', '1.10'],
            ['-123', '-123.00'],
            ['.01', '0.01'],
        ];
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

    public function testRoundTo()
    {
        $this->assertEquals(
            '100',
            (new Amount('99.5'))->roundTo(0)
        );
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

    public function testDivisionByZero()
    {
        $this->expectException(DivisionByZeroException::CLASS);
        (new Amount('100'))->divideBy('0');
    }

    public function testCastToStringArgumentException()
    {
        $this->expectException(InvalidArgumentException::CLASS);
        (new Amount('1'))->divideBy(null);
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
        $zero = new Amount('+0');
        $this->assertTrue($zero->isZero());
        $this->assertFalse($zero->isPositive());
        $this->assertFalse($zero->isNegative());

        $ten = new Amount('+10');
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
            '1000.00',
            (new Amount('100000000000000000000000'))
                ->multiplyWith('10000000000')
                ->divideBy('1000000000000000000000000000000')
                ->getString()
        );
    }

    public function testFloatingPointPrecision()
    {
        $this->assertSame(
            8.0,
            (new Amount('0.1'))->add(new Amount('0.7'))->multiplyWith(10)->getFloat()
        );
    }

    public function testIntegerConversion()
    {
        $this->assertSame(
            9,
            (new Amount('8.5'))->getInt()
        );
    }

    public function numberProvider()
    {
        return [
            [100, '100.0000000000'],
            [100.0, '100.0000000000'],
            [100.00, '100.0000000000'],
            [100.000, '100.0000000000'],
            [123.23, '123.2300000000'],
            [-123.99, '-123.9900000000'],
            [0.23, '0.2300000000'],
            [0.0000001, '0.0000001000'],
            [1000000.0000001, '1000000.0000001000'],
            [-1000000.0000001, '-1000000.0000001000'],
            [999, '999.0000000000'],
            [1.0E+22, '10000000000000000000000.0000000000'],
            [1.000001E-4, '0.0001000001'],
        ];
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
        $this->expectException(InvalidArgumentException::CLASS);
        Amount::createFromNumber('string');
    }

    public function formattedAmountsProvider()
    {
        return [
            ['-10 000,00', ',', ' ', '-10000.00'],
            ['1 234 567:89', ':', ' ', '1234567.89'],
            ['1,234,567.89', '.', ',', '1234567.89'],
            ['1.234.567,89', ',', '.', '1234567.89'],
        ];
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
        return [
            ['1230å', '-123.00'],
            ['1230J', '-123.01'],
            ['1230K', '-123.02'],
            ['1230L', '-123.03'],
            ['1230M', '-123.04'],
            ['1230N', '-123.05'],
            ['1230O', '-123.06'],
            ['1230P', '-123.07'],
            ['1230Q', '-123.08'],
            ['1230R', '-123.09'],
            ['12300', '123.00'],
        ];
    }

    /**
     * @dataProvider signalStringsProvider
     */
    public function testCreateFromSignalString($signalStr, $expected)
    {
        $amount = Amount::createFromSignalString($signalStr);
        $this->assertSame(
            $expected,
            $amount->getString(2),
            "Conversion to decimal"
        );
        $this->assertSame(
            $signalStr,
            $amount->getSignalString(),
            "Conversion back to signal string"
        );
    }

    public function testInvalidSignalString()
    {
        $this->expectException(InvalidArgumentException::CLASS);
        Amount::createFromSignalString('Q123Q'); // not a valid signal string
    }

    public function testAutomaticStringConversion()
    {
        $this->assertSame(
            '100.00',
            (string)new Amount('100')
        );
    }

    public function allocateProvider()
    {
        return [
            [new Amount('100'), 0, [30, 70], [new Amount('30'), new Amount('70')]],
            [new Amount('5'), 0, [30, 70], [new Amount('2'), new Amount('3')]],
            [new Amount('5'), 0, [70, 30], [new Amount('4'), new Amount('1')]],
            [new Amount('0.05'), 2, [70, 30], [new Amount('0.04'), new Amount('0.01')]],
        ];
    }

    /**
     * @dataProvider allocateProvider
     */
    public function testAllocate(Amount $amount, $precision, array $ratios, array $expectedResult)
    {
        foreach ($amount->allocate($ratios, $precision) as $key => $allocatedAmount) {
            $this->assertTrue($allocatedAmount->equals($expectedResult[$key]));
        }
    }
}
