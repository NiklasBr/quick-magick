<?php

/**
 * © 2025 Niklas Brunberg
 * Licensed under AGPL-3.0-only; BSD-3-Clause available via commercial agreement.
 */

declare(strict_types=1);

namespace NiklasBr\QuickMagick\Traits;

use NiklasBr\QuickMagick\Enums\Format;
use NiklasBr\QuickMagick\Enums\Type;
use Spatie\Color\Exceptions\InvalidColorValue;

trait PlasmaTrait
{
    /**
     * @throws InvalidColorValue
     * @throws \ImagickException
     */
    public static function plasmaImage(int $width = 640, int $height = 480, ?string $imagickArgs = 'silver', Format $format = Format::PNG): \Imagick
    {
        return self::img(
            $width,
            $height,
            $format,
            self::imageTypeToPseudoString(Type::PLASMA, $imagickArgs),
        );
    }
}
