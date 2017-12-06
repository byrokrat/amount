<?php

declare(strict_types = 1);

namespace byrokrat\amount\Currency;

/**
 * This file has ben auto generated and should not be edited directly
 */
class MROTest extends \PHPUnit\Framework\TestCase
{
    public function testCurrencyCode()
    {
        $this->assertSame(
            'MRO',
            (new MRO(''))->getCurrencyCode()
        );
    }

    public function testDisplayPrecision()
    {
        $this->assertSame(
            '0',
            (new MRO('0.11111'))->getString()
        );
    }
}
