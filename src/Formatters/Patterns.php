<?php

/**
 * © 2025 Niklas Brunberg
 * Licensed under AGPL-3.0-only; BSD-3-Clause available via commercial agreement.
 */

declare(strict_types=1);

namespace NiklasBr\QuickMagick\Formatters;

use NiklasBr\QuickMagick\Enums\Category;

final class Patterns implements PseudoImageInterface
{
    public static function format(Category $imageType, ?string $arg): string
    {
        $normalizedPattern = \strtoupper((string) $arg);

        if (!\NiklasBr\QuickMagick\Enums\Patterns::isValid($normalizedPattern)) {
            throw new \InvalidArgumentException("Invalid pattern: {$normalizedPattern}");
        }

        return "{$imageType->value}:{$normalizedPattern}";
    }
}
