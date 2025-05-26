<?php

/**
 * © 2025 Niklas Brunberg
 * Licensed under AGPL-3.0-only; BSD-3-Clause available via commercial agreement.
 */

declare(strict_types=1);

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
            'header' => '© '.date('Y').' Niklas Brunberg'.PHP_EOL.'Licensed under AGPL-3.0-only; BSD-3-Clause available via commercial agreement.',
            'comment_type' => 'PHPDoc',
            'validator' => '/© \d{4} .* Licensed under AGPL-3.0-only; BSD-3-Clause available via commercial agreement/s',
            'location' => 'after_open',
        ],
        'modernize_strpos' => true,
        'native_function_invocation' => [
            'include' => ['@compiler_optimized'],
            'scope' => 'namespaced',
            'strict' => false,
        ],
        'numeric_literal_separator' => true,
        'attribute_empty_parentheses' => true,
        'declare_strict_types' => true,
        'final_class' => true,
        'static_lambda' => false, // Interferes with tests
    ])
    ->setFinder(
        (new Finder())
            ->ignoreDotFiles(false)
            ->ignoreVCSIgnored(true)
            ->in(__DIR__)
    )
;
