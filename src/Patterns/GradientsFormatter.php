<?php

/**
 * © 2025 Niklas Brunberg
 * Licensed under AGPL-3.0-only; BSD-3-Clause available via commercial agreement.
 */

declare(strict_types=1);

namespace NiklasBr\FakerImages\Patterns;

use NiklasBr\FakerImages\Enums\Type;

// https://www.imagemagick.org/script/gradient.php
// gradient:
// gradient:fromColor
// gradient:fromColor-toColor
final readonly class GradientsFormatter implements ImagickPseudoImageFormatterInterface
{
    public static function format(Type $imageType, null|float|int|string $arg): string
    {
        return "{$imageType->value}:{$arg}";
    }
}
