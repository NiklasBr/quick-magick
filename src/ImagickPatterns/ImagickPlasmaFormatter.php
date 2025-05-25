<?php

/**
 * © 2025 Niklas Brunberg
 * Licensed under AGPL-3.0-only; BSD-3-Clause available via commercial agreement.
 */

declare(strict_types=1);

namespace NiklasBr\FakerImages\ImagickPatterns;

use NiklasBr\FakerImages\Type;

final class ImagickPlasmaFormatter implements ImagickPseudoImageFormatterInterface
{
    /**
     * @var string[]
     */
    private static array $validPatterns = [
        'fractal',
    ];

    public static function format(Type $imageType, $arg): string
    {
        if (!empty($arg) && !\in_array($arg, self::$validPatterns, true)) {
            throw new \UnexpectedValueException('Unsupported pattern');
        }

        return "{$imageType->value}:{$arg}";
    }
}
