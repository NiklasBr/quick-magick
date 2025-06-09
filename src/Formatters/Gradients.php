<?php

/**
 * © 2025 Niklas Brunberg
 * Licensed under AGPL-3.0-only; BSD-3-Clause available via commercial agreement.
 */

declare(strict_types=1);

namespace NiklasBr\QuickMagick\Formatters;

use NiklasBr\QuickMagick\Enums\Type;
use NiklasBr\QuickMagick\Validators\ColorValidator;
use Spatie\Color\Exceptions\InvalidColorValue;

final readonly class Gradients implements PseudoImageInterface
{
    /**
     * @param null|string $arg Accepts: "color", "color1-color2"
     *
     * @throws InvalidColorValue
     */
    public static function format(Type $imageType, ?string $arg): string
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
    private static function validateArgs(?string $arg): void
    {
        if (empty($arg)) {
            // Will result in 'gradient:' with no argument
            return;
        }

        if (!\str_contains($arg, '-')) {
            // Single color after 'plasma:'
            ColorValidator::isValidColor($arg);

            return;
        }

        [$color1, $color2] = \explode('-', $arg, 2);

        ColorValidator::isValidColor($color1);
        ColorValidator::isValidColor($color2);
    }
}
