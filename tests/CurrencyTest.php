<?php

namespace byrokrat\amount;

use byrokrat\amount\Currency\SEK;
use byrokrat\amount\Currency\EUR;

class CurrencyTest extends \PHPUnit_Framework_TestCase
{
    public function testCreateFromExchange()
    {
        $sek = SEK::createFromExchange(new EUR('10'), '10');
        $this->assertInstanceOf('byrokrat\amount\Currency\SEK', $sek);
        $this->assertEquals('100', $sek->getAmount());
    }

    public function testGetCurrencyCode()
    {
        $this->assertEquals(
            'SEK',
            (new SEK('1'))->getCurrencyCode()
        );
        $this->assertEquals(
            'EUR',
            (new EUR('1'))->getCurrencyCode()
        );
    }

    public function testAddAmountValidation()
    {
        $this->setExpectedException('byrokrat\amount\InvalidArgumentException');
        (new SEK('1'))->add(new EUR('1'));
    }

    public function testSubtractAmountValidation()
    {
        $this->setExpectedException('byrokrat\amount\InvalidArgumentException');
        (new SEK('1'))->subtract(new EUR('1'));
    }

    public function testCompareToAmountValidation()
    {
        $this->setExpectedException('byrokrat\amount\InvalidArgumentException');
        (new SEK('1'))->compareTo(new EUR('1'));
    }

    public function testEqualsAmountValidation()
    {
        $this->setExpectedException('byrokrat\amount\InvalidArgumentException');
        (new SEK('1'))->equals(new EUR('1'));
    }

    public function testIsLessThanAmountValidation()
    {
        $this->setExpectedException('byrokrat\amount\InvalidArgumentException');
        (new SEK('1'))->isLessThan(new EUR('1'));
    }

    public function testIsLessThanOrEqualsAmountValidation()
    {
        $this->setExpectedException('byrokrat\amount\InvalidArgumentException');
        (new SEK('1'))->isLessThanOrEquals(new EUR('1'));
    }

    public function testIsGreaterThanAmountValidation()
    {
        $this->setExpectedException('byrokrat\amount\InvalidArgumentException');
        (new SEK('1'))->isGreaterThan(new EUR('1'));
    }

    public function testIsGreaterThanOrEqualsAmountValidation()
    {
        $this->setExpectedException('byrokrat\amount\InvalidArgumentException');
        (new SEK('1'))->isGreaterThanOrEquals(new EUR('1'));
    }

    public function testAdd()
    {
        $this->assertInstanceOf(
            'byrokrat\amount\Currency\SEK',
            (new SEK('1'))->add(new SEK('1'))
        );
    }

    public function testSubtract()
    {
        $this->assertInstanceOf(
            'byrokrat\amount\Currency\SEK',
            (new SEK('1'))->subtract(new SEK('1'))
        );
    }

    public function testCompareTo()
    {
        $this->assertTrue(
            !!(new SEK('2'))->compareTo(new SEK('1'))
        );
    }

    public function testEquals()
    {
        $this->assertTrue(
            (new SEK('1'))->equals(new SEK('1'))
        );
    }

    public function testIsLessThan()
    {
        $this->assertTrue(
            (new SEK('1'))->isLessThan(new SEK('2'))
        );
    }

    public function testIsLessThanOrEquals()
    {
        $this->assertTrue(
            (new SEK('1'))->isLessThanOrEquals(new SEK('1'))
        );
    }

    public function testIsGreaterThan()
    {
        $this->assertTrue(
            (new SEK('2'))->isGreaterThan(new SEK('1'))
        );
    }

    public function testIsGreaterThanOrEquals()
    {
        $this->assertTrue(
            (new SEK('1'))->isGreaterThanOrEquals(new SEK('1'))
        );
    }
}
