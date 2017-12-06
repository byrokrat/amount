

declare(strict_types = 1);

namespace byrokrat\amount\Currency;

/**
 * This file has ben auto generated and should not be edited directly
 */
class <?= $classname ?>Test extends \PHPUnit\Framework\TestCase
{
    public function testCurrencyCode()
    {
        $this->assertSame(
            '<?= $alpha3 ?>',
            (new <?= $classname ?>(''))->getCurrencyCode()
        );
    }

    public function testDisplayPrecision()
    {
        $this->assertSame(
            '<?= trim('0.' . str_repeat('1', $exp), '.') ?>',
            (new <?= $classname ?>('0.11111'))->getString()
        );
    }
}
