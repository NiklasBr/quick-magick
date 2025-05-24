<?php

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
            'header' => 'TODO LICENSE header',
            'comment_type' => 'PHPDoc',
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
