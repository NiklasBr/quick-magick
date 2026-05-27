<?php

/**
 * © 2026 Niklas Brunberg
 * Licensed under AGPL-3.0-only; BSD-3-Clause available via commercial agreement.
 */

declare(strict_types=1);

namespace NiklasBr\QuickMagick\Internal;

use NiklasBr\QuickMagick\Enums\Category;
use NiklasBr\QuickMagick\Enums\Patterns;
use Spatie\Color\Exceptions\InvalidColorValue;
use Spatie\Color\Hsl;

/**
 * @internal
 */
final readonly class RandomImage
{
    /**
     * Generate a random aesthetically pleasing color using HSL color theory.
     *
     * @return string Hex color string (e.g., '#ff5733')
     *
     * @throws InvalidColorValue
     */
    public static function generateRandomColor(): string
    {
        // Base hues representing color wheel positions (primary/secondary colors)
        $baseHues = [0, 30, 60, 120, 210, 270, 330];
        $randomHue = $baseHues[\array_rand($baseHues)];

        // Saturation: 60-100% for vibrant but not garish colors
        $saturation = \random_int(60, 100);

        // Lightness: 40-70% for good visibility and contrast
        $lightness = \random_int(40, 70);

        $hsl = new Hsl($randomHue, $saturation, $lightness);

        return (string) $hsl->toHex();
    }

    /**
     * Pick a random non-grayscale pattern.
     *
     * @return string Pattern name
     */
    public static function getRandomPattern(): string
    {
        // Get all non-grayscale patterns for better visual variety
        $patterns = \array_filter(
            Patterns::all(),
            static fn (string $pattern): bool => !\str_starts_with($pattern, 'GRAY')
        );

        return $patterns[\array_rand($patterns)];
    }

    /**
     * Pick a random gradient type (linear or radial).
     *
     * @return Category Either Category::LINEAR_GRADIENT or Category::RADIAL_GRADIENT
     */
    public static function getRandomGradientType(): Category
    {
        return 0 === \random_int(0, 1)
            ? Category::LINEAR_GRADIENT
            : Category::RADIAL_GRADIENT;
    }

    /**
     * Generate a random color pair for gradients.
     *
     * @return string Color pair formatted as "color1-color2"
     *
     * @throws InvalidColorValue
     */
    public static function getRandomColorPair(): string
    {
        $color1 = self::generateRandomColor();
        $color2 = self::generateRandomColor();

        return "{$color1}-{$color2}";
    }
}
