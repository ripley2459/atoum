<h1>Atoum's administration</h1>

<div>
    <h2>Scripts</h2>
    <?php

    $scriptsPath = CONTENT . 'scripts';
    FileHandler::checkPath($scriptsPath);
    foreach (normalizedScan($scriptsPath) as $script) {
        if (!str_contains($script, '_')) {
            echo '<button onclick="getFrom(\'' . URL . '/content/scripts/' . $script . '\', \'scriptsResult\')">' . $script . '</button>';
        }
    }

    ?>
    <div id="scriptsResult"></div>
</div>