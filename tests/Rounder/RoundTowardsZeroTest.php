<?php

declare(strict_types = 1);

namespace byrokrat\amount\Rounder;

class RoundTowardsZeroTest extends \PHPUnit\Framework\TestCase
{
    public function testRound()
    {
        $value = '1.01';
        $precision = 0;
        $expected = 'foobar';

        $toolkit = $this->getMockBuilder(Toolkit::CLASS)->getMock();

        $toolkit->expects($this->once())
            ->method('roundTowardsZero')
            ->with($value, $precision)
            ->will($this->returnValue($expected));

        $this->assertSame(
            $expected,
            (new RoundTowardsZero($toolkit))->round($value, $precision)
        );
    }
}
