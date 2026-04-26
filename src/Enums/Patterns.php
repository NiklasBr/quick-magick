<?php

/**
 * © 2025 Niklas Brunberg
 * Licensed under AGPL-3.0-only; BSD-3-Clause available via commercial agreement.
 */

declare(strict_types=1);

namespace NiklasBr\QuickMagick\Enums;

final class Patterns
{
    public const string BRICKS = 'BRICKS';
    public const string CHECKERBOARD = 'CHECKERBOARD';
    public const string CIRCLES = 'CIRCLES';
    public const string CROSSHATCH = 'CROSSHATCH';
    public const string CROSSHATCH30 = 'CROSSHATCH30';
    public const string CROSSHATCH45 = 'CROSSHATCH45';
    public const string FISHSCALES = 'FISHSCALES';
    public const string GRAY0 = 'GRAY0';
    public const string GRAY5 = 'GRAY5';
    public const string GRAY10 = 'GRAY10';
    public const string GRAY15 = 'GRAY15';
    public const string GRAY20 = 'GRAY20';
    public const string GRAY25 = 'GRAY25';
    public const string GRAY30 = 'GRAY30';
    public const string GRAY35 = 'GRAY35';
    public const string GRAY40 = 'GRAY40';
    public const string GRAY45 = 'GRAY45';
    public const string GRAY50 = 'GRAY50';
    public const string GRAY55 = 'GRAY55';
    public const string GRAY60 = 'GRAY60';
    public const string GRAY65 = 'GRAY65';
    public const string GRAY70 = 'GRAY70';
    public const string GRAY75 = 'GRAY75';
    public const string GRAY80 = 'GRAY80';
    public const string GRAY85 = 'GRAY85';
    public const string GRAY90 = 'GRAY90';
    public const string GRAY95 = 'GRAY95';
    public const string GRAY100 = 'GRAY100';
    public const string HEXAGONS = 'HEXAGONS';
    public const string HORIZONTAL = 'HORIZONTAL';
    public const string HORIZONTAL2 = 'HORIZONTAL2';
    public const string HORIZONTAL3 = 'HORIZONTAL3';
    public const string HORIZONTALSAW = 'HORIZONTALSAW';
    public const string HS_BDIAGONAL = 'HS_BDIAGONAL';
    public const string HS_CROSS = 'HS_CROSS';
    public const string HS_DIAGCROSS = 'HS_DIAGCROSS';
    public const string HS_FDIAGONAL = 'HS_FDIAGONAL';
    public const string HS_HORIZONTAL = 'HS_HORIZONTAL';
    public const string HS_VERTICAL = 'HS_VERTICAL';
    public const string LEFT30 = 'LEFT30';
    public const string LEFT45 = 'LEFT45';
    public const string LEFTSHINGLE = 'LEFTSHINGLE';
    public const string OCTAGONS = 'OCTAGONS';
    public const string RIGHT30 = 'RIGHT30';
    public const string RIGHT45 = 'RIGHT45';
    public const string RIGHTSHINGLE = 'RIGHTSHINGLE';
    public const string SMALLFISHSCALES = 'SMALLFISHSCALES';
    public const string VERTICAL = 'VERTICAL';
    public const string VERTICAL2 = 'VERTICAL2';
    public const string VERTICAL3 = 'VERTICAL3';
    public const string VERTICALBRICKS = 'VERTICALBRICKS';
    public const string VERTICALLEFTSHINGLE = 'VERTICALLEFTSHINGLE';
    public const string VERTICALRIGHTSHINGLE = 'VERTICALRIGHTSHINGLE';
    public const string VERTICALSAW = 'VERTICALSAW';

    private const array ALL = [
        self::BRICKS,
        self::CHECKERBOARD,
        self::CIRCLES,
        self::CROSSHATCH,
        self::CROSSHATCH30,
        self::CROSSHATCH45,
        self::FISHSCALES,
        self::GRAY0,
        self::GRAY5,
        self::GRAY10,
        self::GRAY15,
        self::GRAY20,
        self::GRAY25,
        self::GRAY30,
        self::GRAY35,
        self::GRAY40,
        self::GRAY45,
        self::GRAY50,
        self::GRAY55,
        self::GRAY60,
        self::GRAY65,
        self::GRAY70,
        self::GRAY75,
        self::GRAY80,
        self::GRAY85,
        self::GRAY90,
        self::GRAY95,
        self::GRAY100,
        self::HEXAGONS,
        self::HORIZONTAL,
        self::HORIZONTAL2,
        self::HORIZONTAL3,
        self::HORIZONTALSAW,
        self::HS_BDIAGONAL,
        self::HS_CROSS,
        self::HS_DIAGCROSS,
        self::HS_FDIAGONAL,
        self::HS_HORIZONTAL,
        self::HS_VERTICAL,
        self::LEFT30,
        self::LEFT45,
        self::LEFTSHINGLE,
        self::OCTAGONS,
        self::RIGHT30,
        self::RIGHT45,
        self::RIGHTSHINGLE,
        self::SMALLFISHSCALES,
        self::VERTICAL,
        self::VERTICAL2,
        self::VERTICAL3,
        self::VERTICALBRICKS,
        self::VERTICALLEFTSHINGLE,
        self::VERTICALRIGHTSHINGLE,
        self::VERTICALSAW,
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
