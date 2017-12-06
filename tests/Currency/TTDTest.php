<?php

declare(strict_types = 1);

namespace byrokrat\amount\Currency;

/**
 * This file has ben auto generated and should not be edited directly
 */
class TTDTest extends \PHPUnit\Framework\TestCase
{
    public function testCurrencyCode()
    {
        $this->assertSame(
            'TTD',
            (new TTD(''))->getCurrencyCode()
        );
    }

    public function testDisplayPrecision()
    {
        $this->assertSame(
            '0.11',
            (new TTD('0.11111'))->getString()
        );
    }
}
