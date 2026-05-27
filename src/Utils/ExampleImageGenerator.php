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

final readonly class ExampleImage
{
    public function __construct(
        public Category $category = Category::SOLID_COLOR,
        public int $width = 320,
        public int $height = 180,
        public ?string $word = null,
        public string $filename = 'example.png',
        public ?string $description = null,
        public bool $isRandom = false,
        public ?string $randomMethod = null,
    ) {
    }
}

/**
 * @internal used to generate example images for the documentation
 *
 * Generates a representative set of images showcasing all features of QuickMagick
 * with carefully selected, complementary color combinations for visual appeal
 */
final class ExampleImageGenerator
{
    /**
     * @var array<int, ExampleImage> $images
     */
    public static array $images = [];

    private static function getPresetImages(): array
    {
        return [
            // Solid Colors - Simple, flat color backgrounds
            new ExampleImage(
                category: Category::SOLID_COLOR,
                word: '#2E86AB',
                filename: 'solid_color.png',
                description: 'Solid color canvas - A simple teal blue background',
            ),

            // Linear Gradients - Smooth color transitions
            new ExampleImage(
                category: Category::LINEAR_GRADIENT,
                word: '#667EEA-#764BA2',
                filename: 'linear_gradient_purple.png',
                description: 'Linear gradient - Purple to indigo vertical transition',
            ),
            new ExampleImage(
                category: Category::LINEAR_GRADIENT,
                word: '#F093FB-#F5576C',
                filename: 'linear_gradient_pink.png',
                description: 'Linear gradient - Pink to coral vertical transition',
            ),
            new ExampleImage(
                category: Category::LINEAR_GRADIENT,
                word: '#4FACFE-#00F2FE',
                filename: 'linear_gradient_cyan.png',
                description: 'Linear gradient - Sky blue to cyan vertical transition',
            ),

            // Radial Gradients - Circular color transitions
            new ExampleImage(
                category: Category::RADIAL_GRADIENT,
                word: '#FF6B6B-#FFE66D',
                filename: 'radial_gradient_sunset.png',
                description: 'Radial gradient - Red to golden yellow circular transition',
            ),
            new ExampleImage(
                category: Category::RADIAL_GRADIENT,
                word: '#95E1D3-#F38181',
                filename: 'radial_gradient_peachy.png',
                description: 'Radial gradient - Mint to peachy circular transition',
            ),

            // Plasma - Fractal noise patterns
            new ExampleImage(
                category: Category::PLASMA,
                word: '#0061FF',
                filename: 'plasma_electric_blue.png',
                description: 'Plasma effect - Electric blue fractal pattern',
            ),
            new ExampleImage(
                category: Category::PLASMA,
                word: '#FF006E-#FB5607',
                filename: 'plasma_vibrant.png',
                description: 'Plasma effect - Bold magenta to orange fractal',
            ),

            // Patterns - Repeating patterns
            new ExampleImage(
                category: Category::PATTERN,
                word: 'CROSSHATCH30',
                filename: 'pattern_crosshatch.png',
                description: 'Pattern - Crosshatch texture',
            ),
            new ExampleImage(
                category: Category::PATTERN,
                word: 'SMALLFISHSCALES',
                filename: 'pattern_fishscales.png',
                description: 'Pattern - Small fish scales texture',
            ),

            // Text Labels - Simple text rendering
            new ExampleImage(
                category: Category::LABEL,
                height: 120,
                word: 'QuickMagick',
                filename: 'label_text.png',
                description: 'Label - Simple text rendering on solid background',
            ),

            // Text Captions - Multi-line wrapped text
            new ExampleImage(
                category: Category::CAPTION,
                height: 200,
                word: 'A powerful image generation library for PHP with zero external dependencies.',
                filename: 'caption_text.png',
                description: 'Caption - Auto-wrapped multi-line text',
            ),
        ];
    }

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

        self::$images = self::getPresetImages();

        // Generate random image examples for additional variety
        $images = self::generateRandomImages();
        $allImages = array_merge(self::$images, $images);

        $successCount = 0;
        $failureCount = 0;

        foreach ($allImages as $index => $image) {
            $targetFile = $docsImgPath.\DIRECTORY_SEPARATOR.$image->filename;
            $fileNum = str_pad((string) ($index + 1), \strlen((string) \count($allImages)), '0', STR_PAD_LEFT);
            $totalNum = \count($allImages);

            echo "[{$fileNum}/{$totalNum}] Generating {$image->filename}";
            if (!empty($image->description)) {
                echo " ({$image->description})";
            }
            echo '... ';

            try {
                // Use public QuickMagick methods for random images
                if ($image->isRandom && $image->randomMethod !== null) {
                    $method = $image->randomMethod;
                    // Call the public method with a temp dir, then move to target with proper name
                    $tempDir = \sys_get_temp_dir();

                    /** @phpstan-ignore-next-line due to "Cannot cast mixed to string." is not valid for phpstan max level, but this is not sensitive code */
                    $generatedPath = (string) QuickMagick::$method($tempDir, $image->width, $image->height, Format::PNG);
                    \rename($generatedPath, $targetFile);
                } else {
                    QuickMagick::createImageFile(
                        filePath: $targetFile,
                        width: $image->width,
                        height: $image->height,
                        category: $image->category,
                        word: $image->word,
                        format: Format::PNG
                    );
                }

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

        // Generate a markdown file with the arguments used for each example image
        $mdFile = $docsPath.\DIRECTORY_SEPARATOR.'example-images.md';
        $mdLines = [];
        $mdLines[] = '# Example images and generation arguments';
        $mdLines[] = '';
        $mdLines[] = 'This file lists the arguments used to generate each example image with QuickMagick.';
        $mdLines[] = '';

        foreach ($allImages as $image) {
            $relativeImagePath = 'img/'.$image->filename;
            $altText = !empty($image->description) ? $image->description : $image->filename;

            $mdLines[] = "## {$image->filename}";
            if (!empty($image->description)) {
                $mdLines[] = $image->description;
            }
            $mdLines[] = '';
            $mdLines[] = '<table><tr><td style="width: 400px;">Preview</td><td>Generation</td></tr>';

            // Generate code example based on whether it's a random image or preset
            if ($image->isRandom && $image->randomMethod !== null) {
                $method = $image->randomMethod;
                $code = "QuickMagick::{$method}(\n"
                    ."    dir: __DIR__ . '/img',\n"
                    ."    width: {$image->width},\n"
                    ."    height: {$image->height},\n"
                    ."    format: Format::PNG\n"
                    .');';
            } else {
                $categoryConst = 'Category::'.$image->category->name;
                $wordValue = null === $image->word ? 'null' : var_export($image->word, true);

                $code = "QuickMagick::createImageFile(\n"
                    ."    filePath: __DIR__ . '/img/{$image->filename}',\n"
                    ."    width: {$image->width},\n"
                    ."    height: {$image->height},\n"
                    ."    category: {$categoryConst},\n"
                    ."    word: {$wordValue},\n"
                    ."    format: Format::PNG\n"
                    .');';
            }

            $imageCell = "<img src=\"{$relativeImagePath}\" alt=\"{$altText}\" />";
            $codeForMd = str_replace("\n", '&#10;', $code);

            $mdLines[] = "<tr><td style=\"width: 400px;\">{$imageCell}</td><td style=\"width: 420px;\"><pre><code class=\"language-php\">{$codeForMd}</code></pre></td></tr></table>";
            $mdLines[] = '';
        }

        $mdContent = implode("\n", $mdLines);

        if (false === @file_put_contents($mdFile, $mdContent)) {
            throw new \RuntimeException('Failed to write example markdown file: '.$mdFile);
        }

        echo "Wrote example arguments to: {$mdFile}\n";
    }

    /**
     * Generate random image examples for showcase.
     *
     * @return array<int, ExampleImage>
     */
    private static function generateRandomImages(): array
    {
        return [
            // Random Pattern
            new ExampleImage(
                category: Category::PATTERN,
                filename: 'random_pattern.png',
                description: 'Random pattern - Procedurally generated texture pattern',
                isRandom: true,
                randomMethod: 'randomPattern',
            ),

            // Random Gradient (linear or radial)
            new ExampleImage(
                category: Category::SOLID_COLOR,
                filename: 'random_gradient.png',
                description: 'Random gradient - Procedurally generated color gradient',
                isRandom: true,
                randomMethod: 'randomGradient',
            ),

            // Random Plasma
            new ExampleImage(
                category: Category::PLASMA,
                filename: 'random_plasma.png',
                description: 'Random plasma - Procedurally generated fractal pattern',
                isRandom: true,
                randomMethod: 'randomPlasma',
            ),
        ];
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
