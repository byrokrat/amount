<?php

namespace byrokrat\amount\Rounder;

class RoundHalfTowardsZeroTest extends \PHPUnit_Framework_TestCase
{
    public function testRound()
    {
        $value = '1.01';
        $precision = 0;
        $expected = 'foobar';

        $toolkit = $this->createMock('byrokrat\amount\Rounder\Toolkit');

        $toolkit->expects($this->once())
            ->method('roundToNearest')
            ->with($value, $precision)
            ->will($this->returnValue($expected));

        $this->assertSame(
            $expected,
            (new RoundHalfTowardsZero($toolkit))->round($value, $precision)
        );
    }

    public function breakTieProvider()
    {
        return array(
            array('1.5', 0, '1'),
            array('-1.5', 0, '-1'),
        );
    }

    /**
     * @dataProvider breakTieProvider
     */
    public function testBreakTie($value, $precision, $expected)
    {
        $this->assertSame(
            $expected,
            (new RoundHalfTowardsZero)->round($value, $precision)
        );
    }
}
