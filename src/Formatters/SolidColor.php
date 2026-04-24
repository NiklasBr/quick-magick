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

final readonly class SolidColor implements PseudoImageInterface
{
    /**
     * @throws InvalidColorValue
     */
    public static function format(Category $imageType, ?string $arg): string
    {
        $color = $arg ?? 'silver';
        ColorValidator::isValidColor($color);

        return "{$imageType->value}:{$color}";
    }
}
