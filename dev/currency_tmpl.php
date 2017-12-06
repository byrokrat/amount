

declare(strict_types = 1);

namespace byrokrat\amount\Currency;

/**
 * The <?= $name ?> currency
 *
 * This file has ben auto generated and should not be edited directly
 */
class <?= $classname ?> extends \byrokrat\amount\Currency
{
    public function getCurrencyCode(): string
    {
        return '<?= $alpha3 ?>';
    }

    public static function getDisplayPrecision(): int
    {
        return <?= $exp ?>;
    }
}
