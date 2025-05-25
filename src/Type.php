<?php

/**
 * © 2025 Niklas Brunberg
 * Licensed under AGPL-3.0-only; BSD-3-Clause available via commercial agreement.
 */

declare(strict_types=1);

namespace NiklasBr\FakerImages;

// https://www.imagemagick.org/script/formats.php
enum Type: string
{
    case LINEAR_GRADIENT = 'gradient';
    case RADIAL_GRADIENT = 'radial-gradient';
    case PATTERN = 'pattern';
    case PLASMA = 'plasma';
    case SOLID_COLOR = 'canvas';
    case MAGICK = 'magick';
    case HALD_CUT = 'hald';

    case UNKNOWN = 'unknown';
}
