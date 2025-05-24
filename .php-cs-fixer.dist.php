<?php

declare(strict_types=1);

/**
 * © 2025 Niklas Brunberg
 * SPDX-License-Identifier: AGPL-3.0-only.
 */

use PhpCsFixer\Config;
use PhpCsFixer\Finder;
use PhpCsFixer\Runner\Parallel\ParallelConfigFactory;

return (new Config())
    ->setParallelConfig(ParallelConfigFactory::detect())
    ->setRiskyAllowed(true)
    ->setRules([
        '@Symfony:risky' => true,
        '@PhpCsFixer' => true,
        '@PhpCsFixer:risky' => true,
        'general_phpdoc_annotation_remove' => [
            'annotations' => ['expectedDeprecation'],
        ],
        'header_comment' => [
            'header' => '© '.date('Y').' Niklas Brunberg'.PHP_EOL.'SPDX-License-Identifier: AGPL-3.0-only',
            'comment_type' => 'PHPDoc',
            'validator' => '/© \d{4} .* AGPL-3.0-only/s',
        ],
        'modernize_strpos' => true,
        'numeric_literal_separator' => true,
        'attribute_empty_parentheses' => true,
        'final_class' => true,
    ])
    ->setFinder(
        (new Finder())
            ->ignoreDotFiles(false)
            ->ignoreVCSIgnored(true)
            ->in(__DIR__)
    )
;
