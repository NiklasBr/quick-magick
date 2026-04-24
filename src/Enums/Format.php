<?php

/**
 * © 2025 Niklas Brunberg
 * Licensed under AGPL-3.0-only; BSD-3-Clause available via commercial agreement.
 */

declare(strict_types=1);

namespace NiklasBr\QuickMagick\Enums;

final class Format
{
    public const BMP = 'bmp';
    public const GIF = 'gif';
    public const JPEG = 'jpeg';
    public const PNG = 'png';
    public const TIFF = 'tiff';
    public const WEBP = 'webp';

    private const ALL = [
        self::BMP,
        self::GIF,
        self::JPEG,
        self::PNG,
        self::TIFF,
        self::WEBP,
    ];

    /** @return string[] */
    public static function all(): array
    {
        return self::ALL;
    }

    public static function isValid(string $format): bool
    {
        return \in_array($format, self::ALL, true);
    }
}
