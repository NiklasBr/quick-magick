<?php

/**
 * © 2025 Niklas Brunberg
 * Licensed under AGPL-3.0-only; BSD-3-Clause available via commercial agreement.
 */

declare(strict_types=1);

namespace NiklasBr\FakerImages\Patterns;

use NiklasBr\FakerImages\Enums\Type;
use NiklasBr\FakerImages\Validator;
use Spatie\Color\Exceptions\InvalidColorValue;

// https://www.imagemagick.org/script/gradient.php
// gradient:
// gradient:fromColor
// gradient:fromColor-toColor
final readonly class GradientsFormatter implements ImagickPseudoImageFormatterInterface
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
            Validator::isValidColor($arg);

            return;
        }

        [$color1, $color2] = \explode('-', $arg, 2);

        Validator::isValidColor($color1);
        Validator::isValidColor($color2);
    }
}
