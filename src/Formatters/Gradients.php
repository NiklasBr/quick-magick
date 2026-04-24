<?php

/**
 * © 2025 Niklas Brunberg
 * Licensed under AGPL-3.0-only; BSD-3-Clause available via commercial agreement.
 */

declare(strict_types=1);

namespace NiklasBr\QuickMagick\Formatters;

use NiklasBr\QuickMagick\Enums\Category;
use NiklasBr\QuickMagick\Validators\ColorValidator;
use Spatie\Color\Exceptions\InvalidColorValue;

final readonly class Gradients implements PseudoImageInterface
{
    /**
     * @param null|string $arg Accepts: "color", "color1-color2"
     *
     * @throws InvalidColorValue
     */
    public static function format(Category $imageType, ?string $arg): string
    {
        self::validateArgs((string) $arg);

        return "{$imageType->value}:{$arg}";
    }

    /**
     * https://www.imagemagick.org/script/gradient.php
     * gradient:
     * gradient:fromColor
     * gradient:fromColor-toColor.
     *
     * @throws InvalidColorValue
     */
    private static function validateArgs(?string $argument): void
    {
        if (empty($argument)) {
            // Will result in 'gradient:' with no argument
            return;
        }

        if (!\str_contains($argument, '-')) {
            // Single color after 'gradient:'
            ColorValidator::isValidColor($argument);

            return;
        }

        [$startColor, $endColor] = \explode('-', $argument, 2);

        ColorValidator::isValidColor($startColor);
        ColorValidator::isValidColor($endColor);
    }
}
