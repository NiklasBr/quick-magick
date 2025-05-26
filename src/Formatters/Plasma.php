<?php

/**
 * © 2025 Niklas Brunberg
 * Licensed under AGPL-3.0-only; BSD-3-Clause available via commercial agreement.
 */

declare(strict_types=1);

namespace NiklasBr\FakerImages\Formatters;

use NiklasBr\FakerImages\Enums\Type;
use NiklasBr\FakerImages\Validator;
use Spatie\Color\Exceptions\InvalidColorValue;

final class Plasma implements ImagickPseudoImageInterface
{
    /**
     * @var string[]
     */
    private static array $validPatterns = [
        'fractal',
    ];

    /**
     * @param null|string $arg Accepts: "plasma", "color", "color1-color2", "plasma-color"
     *
     * @throws InvalidColorValue
     */
    public static function format(Type $imageType, ?string $arg): string
    {
        // https://usage.imagemagick.org/canvas/#plasma
        self::validateArgs($arg);

        return "{$imageType->value}:{$arg}";
    }

    /**
     * @throws InvalidColorValue
     */
    private static function validateArgs(?string $arg): void
    {
        if (empty($arg)) {
            // Will result in 'fractal:' with no argument
            return;
        }

        if (!\str_contains($arg, '-')) {
            // Single color after 'plasma:'
            Validator::isValidColor($arg);

            return;
        }

        [$color1, $color2] = \explode('-', $arg, 2);

        // Will result in 'fractal:plasma', valid
        if (\in_array($color1, self::$validPatterns, true)) {
            Validator::isValidColor($color2);

            return;
        }

        Validator::isValidColor($color1);
        Validator::isValidColor($color2);
    }
}
