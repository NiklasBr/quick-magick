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
     * @throws InvalidColorValue
     */
    public static function format(Type $imageType, null|float|int|string $arg): string
    {
        if (str_contains($arg, '-')) {
            foreach (explode('-', $arg) as $color) {
                Validator::isValidColor($color);
            }
        } else {
            Validator::isValidColor($arg);
        }

        return "{$imageType->value}:{$arg}";
    }
}
