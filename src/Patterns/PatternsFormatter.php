<?php

/**
 * © 2025 Niklas Brunberg
 * Licensed under AGPL-3.0-only; BSD-3-Clause available via commercial agreement.
 */

declare(strict_types=1);

namespace NiklasBr\FakerImages\Patterns;

use NiklasBr\FakerImages\Enums\Type;

final class PatternsFormatter implements ImagickPseudoImageFormatterInterface
{
    /**
     * @var string[]
     */
    private static array $validPatterns = [
        'BRICKS',
        'CHECKERBOARD',
        'CIRCLES',
        'CROSSHATCH',
        'CROSSHATCH30',
        'CROSSHATCH45',
        'FISHSCALES',
        'GRAY0',
        'GRAY5',
        'GRAY10',
        'GRAY15',
        'GRAY20',
        'GRAY25',
        'GRAY30',
        'GRAY35',
        'GRAY40',
        'GRAY45',
        'GRAY50',
        'GRAY55',
        'GRAY60',
        'GRAY65',
        'GRAY70',
        'GRAY75',
        'GRAY80',
        'GRAY85',
        'GRAY90',
        'GRAY95',
        'GRAY100',
        'HEXAGONS',
        'HORIZONTAL',
        'HORIZONTAL2',
        'HORIZONTAL3',
        'HORIZONTALSAW',
        'HS_BDIAGONAL',
        'HS_CROSS',
        'HS_DIAGCROSS',
        'HS_FDIAGONAL',
        'HS_HORIZONTAL',
        'HS_VERTICAL',
        'LEFT30',
        'LEFT45',
        'LEFTSHINGLE',
        'OCTAGONS',
        'RIGHT30',
        'RIGHT45',
        'RIGHTSHINGLE',
        'SMALLFISHSCALES',
        'VERTICAL',
        'VERTICAL2',
        'VERTICAL3',
        'VERTICALBRICKS',
        'VERTICALLEFTSHINGLE',
        'VERTICALRIGHTSHINGLE',
        'VERTICALSAW',
    ];

    public static function format(Type $imageType, null|float|int|string $arg): string
    {
        if (!\in_array($arg, self::$validPatterns, true)) {
            throw new \InvalidArgumentException('Unsupported pattern');
        }

        return "{$imageType->value}:{$arg}";
    }
}
