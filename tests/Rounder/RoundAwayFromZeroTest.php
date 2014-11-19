<?php

namespace ledgr\amount\Rounder;

class RoundAwayFromZeroTest extends \PHPUnit_Framework_TestCase
{
    public function testRound()
    {
        $value = '1.01';
        $precision = 0;
        $expected = 'foobar';

        $toolkit = $this->getMock('ledgr\amount\Rounder\Toolkit');

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
