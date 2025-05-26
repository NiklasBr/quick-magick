<?php

/**
 * © 2025 Niklas Brunberg
 * Licensed under AGPL-3.0-only; BSD-3-Clause available via commercial agreement.
 */

declare(strict_types=1);

namespace NiklasBr\FakerImages\Patterns;

use NiklasBr\FakerImages\Enums\Type;
use NiklasBr\FakerImages\Validator;

final readonly class SolidColorFormatter implements ImagickPseudoImageFormatterInterface
{
    public static function format(Type $imageType, ?string $arg): string
    {
        Validator::isValidColor($arg);

        return "{$imageType->value}:{$arg}";
    }
}
