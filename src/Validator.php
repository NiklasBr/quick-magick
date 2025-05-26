<?php

/**
 * © 2025 Niklas Brunberg
 * Licensed under AGPL-3.0-only; BSD-3-Clause available via commercial agreement.
 */

declare(strict_types=1);

namespace NiklasBr\FakerImages;

use Spatie\Color;
use Spatie\Color\Exceptions\InvalidColorValue;

final readonly class Validator
{
    /**
     * @throws InvalidColorValue
     */
    public static function isValidColor(string $colorString): void
    {
        if (\str_contains($colorString, '-')) {
            foreach (\explode('-', $colorString) as $colorString) {
                Color\Factory::fromString($colorString);
            }
        } else {
            Color\Factory::fromString($colorString);
        }
    }
}
