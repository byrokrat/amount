<?php

declare(strict_types = 1);

namespace byrokrat\amount\Rounder;

class RoundHalfToEvenTest extends \PHPUnit\Framework\TestCase
{
    public function testRound()
    {
        $value = '1.01';
        $precision = 0;
        $expected = 'foobar';

        $toolkit = $this->getMockBuilder(Toolkit::CLASS)->getMock();

        $toolkit->expects($this->once())
            ->method('roundToNearest')
            ->with($value, $precision)
            ->will($this->returnValue($expected));

        $this->assertSame(
            $expected,
            (new RoundHalfToEven($toolkit))->round($value, $precision)
        );
    }

    public function breakTieProvider()
    {
        return [
            ['1.5', 0, '2'],
            ['-1.5', 0, '-2'],
            ['2.5', 0, '2'],
            ['-2.5', 0, '-2'],
        ];
    }

    /**
     * @dataProvider breakTieProvider
     */
    public function testBreakTie($value, $precision, $expected)
    {
        $this->assertSame(
            $expected,
            (new RoundHalfToEven)->round($value, $precision)
        );
    }
}
