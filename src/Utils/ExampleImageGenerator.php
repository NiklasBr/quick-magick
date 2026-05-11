<?php

/**
 * © 2025 Niklas Brunberg
 * Licensed under AGPL-3.0-only; BSD-3-Clause available via commercial agreement.
 */

declare(strict_types=1);

namespace NiklasBr\QuickMagick\Utils;

use NiklasBr\QuickMagick\Enums\Category;
use NiklasBr\QuickMagick\Enums\Format;
use NiklasBr\QuickMagick\QuickMagick;
use Spatie\Color\Exceptions\InvalidColorValue;

/**
 * @internal used to generate example images for the documentation
 *
 * Generates a representative set of images showcasing all features of QuickMagick
 * with carefully selected, complementary color combinations for visual appeal
 */
final class ExampleImageGenerator
{
    /**
     * @var array<int, array{
     *  category: Category,
     * width: int,
     * height: int,
     * word: ?string,
     * filename: string,
     * description: ?string,
     * }> $images
     */
    public static array $images = [
        // Solid Colors - Simple, flat color backgrounds
        [
            'category' => Category::SOLID_COLOR,
            'width' => 320,
            'height' => 180,
            'word' => '#2E86AB',
            'filename' => 'solid_color.png',
            'description' => 'Solid color canvas - A simple teal blue background',
        ],

        // Linear Gradients - Smooth color transitions
        [
            'category' => Category::LINEAR_GRADIENT,
            'width' => 320,
            'height' => 180,
            'word' => '#667EEA-#764BA2',
            'filename' => 'linear_gradient_purple.png',
            'description' => 'Linear gradient - Purple to indigo vertical transition',
        ],
        [
            'category' => Category::LINEAR_GRADIENT,
            'width' => 320,
            'height' => 180,
            'word' => '#F093FB-#F5576C',
            'filename' => 'linear_gradient_pink.png',
            'description' => 'Linear gradient - Pink to coral vertical transition',
        ],
        [
            'category' => Category::LINEAR_GRADIENT,
            'width' => 320,
            'height' => 180,
            'word' => '#4FACFE-#00F2FE',
            'filename' => 'linear_gradient_cyan.png',
            'description' => 'Linear gradient - Sky blue to cyan vertical transition',
        ],

        // Radial Gradients - Circular color transitions
        [
            'category' => Category::RADIAL_GRADIENT,
            'width' => 320,
            'height' => 180,
            'word' => '#FF6B6B-#FFE66D',
            'filename' => 'radial_gradient_sunset.png',
            'description' => 'Radial gradient - Red to golden yellow circular transition',
        ],
        [
            'category' => Category::RADIAL_GRADIENT,
            'width' => 320,
            'height' => 180,
            'word' => '#95E1D3-#F38181',
            'filename' => 'radial_gradient_peachy.png',
            'description' => 'Radial gradient - Mint to peachy circular transition',
        ],

        // Plasma - Fractal noise patterns
        [
            'category' => Category::PLASMA,
            'width' => 320,
            'height' => 180,
            'word' => '#0061FF',
            'filename' => 'plasma_electric_blue.png',
            'description' => 'Plasma effect - Electric blue fractal pattern',
        ],
        [
            'category' => Category::PLASMA,
            'width' => 320,
            'height' => 180,
            'word' => '#FF006E-#FB5607',
            'filename' => 'plasma_vibrant.png',
            'description' => 'Plasma effect - Bold magenta to orange fractal',
        ],

        // Patterns - Repeating patterns
        [
            'category' => Category::PATTERN,
            'width' => 320,
            'height' => 180,
            'word' => 'CROSSHATCH30',
            'filename' => 'pattern_crosshatch.png',
            'description' => 'Pattern - Crosshatch texture',
        ],
        [
            'category' => Category::PATTERN,
            'width' => 320,
            'height' => 180,
            'word' => 'SMALLFISHSCALES',
            'filename' => 'pattern_fishscales.png',
            'description' => 'Pattern - Small fish scales texture',
        ],

        // Text Labels - Simple text rendering
        [
            'category' => Category::LABEL,
            'width' => 400,
            'height' => 120,
            'word' => 'QuickMagick',
            'filename' => 'label_text.png',
            'description' => 'Label - Simple text rendering on solid background',
        ],

        // Text Captions - Multi-line wrapped text
        [
            'category' => Category::CAPTION,
            'width' => 320,
            'height' => 200,
            'word' => 'A powerful image generation library for PHP with zero external dependencies.',
            'filename' => 'caption_text.png',
            'description' => 'Caption - Auto-wrapped multi-line text',
        ],
    ];

    /**
     * Generate all example images to the docs/img directory.
     *
     * @throws \ImagickException
     * @throws InvalidColorValue
     */
    public static function run(): void
    {
        $docsPath = \realpath(__DIR__.'/../../docs/');

        if (!$docsPath || !\is_dir($docsPath)) {
            throw new \RuntimeException('Documentation directory not found at: '.__DIR__.'/../../docs/');
        }

        $docsImgPath = $docsPath.\DIRECTORY_SEPARATOR.'img';

        // Create img subdirectory if it doesn't exist
        if (!\is_dir($docsImgPath) && !\mkdir($docsImgPath, 0755, true)) {
            throw new \RuntimeException('Failed to create docs/img directory');
        }

        echo "\n--- QuickMagick Example Image Generator ---\n\n";

        $successCount = 0;
        $failureCount = 0;

        foreach (self::$images as $index => $image) {
            $targetFile = $docsImgPath.\DIRECTORY_SEPARATOR.$image['filename'];
            $fileNum = $index + 1;
            $totalNum = \count(self::$images);

            echo "[{$fileNum}/{$totalNum}] Generating {$image['filename']}";
            if (!empty($image['description'])) {
                echo " ({$image['description']})";
            }
            echo '... ';

            try {
                QuickMagick::createImageFile(
                    filePath: $targetFile,
                    width: $image['width'],
                    height: $image['height'],
                    category: $image['category'],
                    word: $image['word'],
                    format: Format::PNG
                );

                echo "✓\n";
                ++$successCount;
            } catch (\Exception $e) {
                echo "✗ Error: {$e->getMessage()}\n";
                ++$failureCount;
            }
        }

        echo "\n--- Generation Complete ---\n";
        echo "Successfully generated: {$successCount} image(s)\n";

        if ($failureCount > 0) {
            echo "Failed to generate: {$failureCount} image(s)\n";

            exit(1);
        }

        echo "All example images are ready in docs/img/\n\n";
    }
}

// Execution logic
require_once __DIR__.'/../../vendor/autoload.php';

try {
    ExampleImageGenerator::run();
    echo "\nAll example images generated successfully.\n";
} catch (\Exception $e) {
    echo "\nError: ".$e->getMessage()."\n";

    exit(1);
}
