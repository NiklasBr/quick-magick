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

final class PlasmaFormatter implements ImagickPseudoImageFormatterInterface
{
    /**
     * @var string[]
     */
    private static array $validPatterns = [
        'fractal',
    ];

    /**
     * @throws InvalidColorValue
     */
    public static function format(Type $imageType, ?string $arg): string
    {
        // https://usage.imagemagick.org/canvas/#plasma
        if (!empty($arg)) {
            if (str_contains($arg, '-')) {
                $args = explode('-', $arg);
                if (!empty($args[0]) && !\in_array($args[0], self::$validPatterns, true)) {
                    throw new \InvalidArgumentException('Unsupported pattern');
                }

                Validator::isValidColor($args[1]);
            } else {
                if (!\in_array($arg, self::$validPatterns, true)) {
                    throw new \InvalidArgumentException('Unsupported pattern');
                }
            }
        }

        return "{$imageType->value}:{$arg}";
    }
}
