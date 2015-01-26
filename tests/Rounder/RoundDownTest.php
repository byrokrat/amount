<?php

namespace byrokrat\amount\Rounder;

class RoundDownTest extends \PHPUnit_Framework_TestCase
{
    public function testRound()
    {
        $value = '1.01';
        $precision = 0;
        $expected = 'foobar';

        $toolkit = $this->getMock('byrokrat\amount\Rounder\Toolkit');

        $toolkit->expects($this->once())
            ->method('roundDown')
            ->with($value, $precision)
            ->will($this->returnValue($expected));

        $this->assertSame(
            $expected,
            (new RoundDown($toolkit))->round($value, $precision)
        );
    }
}
