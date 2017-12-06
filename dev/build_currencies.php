<?php
/**
 * Script to generate ISO 4217 currencies
 *
 * Usage: php build_currencies.php
 */

include 'vendor/autoload.php';

$srcPath = realpath(__DIR__ . '/../src/Currency');
$testPath = realpath(__DIR__ . '/../tests/Currency');

foreach ((new Alcohol\ISO4217)->getAll() as $def) {
    echo "Generating {$def['alpha3']}";

    $def['classname'] = $def['alpha3'] == 'TRY' ? '_TRY' : $def['alpha3'];

    file_put_contents(
        "$srcPath/{$def['classname']}.php",
        '<?php' . render_template('currency_tmpl.php', $def)
    );

    file_put_contents(
        "$testPath/{$def['classname']}Test.php",
        '<?php' . render_template('test_tmpl.php', $def)
    );

    echo " [DONE]\n";
}

function render_template($template, array $values)
{
    extract($values);
    ob_start();
    include __DIR__ . DIRECTORY_SEPARATOR . $template;
    $content = ob_get_contents();
    ob_end_clean();
    return $content;
}
