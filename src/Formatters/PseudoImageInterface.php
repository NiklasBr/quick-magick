<?php

/**
 * © 2025 Niklas Brunberg
 * Licensed under AGPL-3.0-only; BSD-3-Clause available via commercial agreement.
 */

declare(strict_types=1);

namespace NiklasBr\QuickMagick\Formatters;

use NiklasBr\QuickMagick\Enums\Type;

interface PseudoImageInterface
{
    /**
     * @throws \InvalidArgumentException If missing or unable to use any required argument
     */
    public static function format(Type $imageType, ?string $arg): string;
}
