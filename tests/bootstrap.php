<?php

/**
 * © 2025 Niklas Brunberg
 * Licensed under AGPL-3.0-only; BSD-3-Clause available via commercial agreement.
 */

declare(strict_types=1);

require_once __DIR__.'/../vendor/autoload.php';

$outDir = __DIR__.'/out';

if (!is_dir($outDir)) {
    return;
}

foreach (glob($outDir.'/*') ?: [] as $path) {
    if ('.gitkeep' === basename($path)) {
        continue;
    }

    if (is_file($path) || is_link($path)) {
        @unlink($path);
    }
}
