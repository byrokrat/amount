<?php

declare(strict_types = 1);

namespace byrokrat\amount\Currency;

/**
 * This file has ben auto generated and should not be edited directly
 */
class ZARTest extends \PHPUnit\Framework\TestCase
{
    public function testCurrencyCode()
    {
        $this->assertSame(
            'ZAR',
            (new ZAR(''))->getCurrencyCode()
        );
    }

    public function testDisplayPrecision()
    {
        $this->assertSame(
            '0.11',
            (new ZAR('0.11111'))->getString()
        );
    }
}
