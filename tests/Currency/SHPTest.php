<?php

declare(strict_types = 1);

namespace byrokrat\amount\Currency;

/**
 * This file has ben auto generated and should not be edited directly
 */
class SHPTest extends \PHPUnit\Framework\TestCase
{
    public function testCurrencyCode()
    {
        $this->assertSame(
            'SHP',
            (new SHP(''))->getCurrencyCode()
        );
    }

    public function testDisplayPrecision()
    {
        $this->assertSame(
            '0.11',
            (new SHP('0.11111'))->getString()
        );
    }
}
