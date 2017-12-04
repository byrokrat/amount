<?php

namespace byrokrat\amount\Rounder;

class RoundAwayFromZeroTest extends \PHPUnit\Framework\TestCase
{
    public function testRound()
    {
        $value = '1.01';
        $precision = 0;
        $expected = 'foobar';

        $toolkit = $this->getMockBuilder('byrokrat\amount\Rounder\Toolkit')->getMock();

        $toolkit->expects($this->once())
            ->method('roundAwayFromZero')
            ->with($value, $precision)
            ->will($this->returnValue($expected));

        $this->assertSame(
            $expected,
            (new RoundAwayFromZero($toolkit))->round($value, $precision)
        );
    }
}
