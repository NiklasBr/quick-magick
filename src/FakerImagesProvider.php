<?php

/**
 * © 2025 Niklas Brunberg
 * Licensed under AGPL-3.0-only; BSD-3-Clause available via commercial agreement.
 */

declare(strict_types=1);

namespace NiklasBr\FakerImages;

use Faker\Provider\Image;
use NiklasBr\FakerImages\Enums\Format;
use NiklasBr\FakerImages\Enums\Type;
use NiklasBr\FakerImages\Patterns\GradientsFormatter;
use NiklasBr\FakerImages\Patterns\PatternsFormatter;
use NiklasBr\FakerImages\Patterns\PlasmaFormatter;
use NiklasBr\FakerImages\Patterns\SolidColorFormatter;

final class FakerImagesProvider extends Image
{
    /**
     * @param null|string      $dir
     * @param int              $width
     * @param int              $height
     * @param null|string|Type $category  Any Imagick keyword as available in the Type enum
     * @param bool             $fullPath
     * @param bool             $randomize
     * @param null|string      $word      Any primary argument to the Imagick keyword, e.g. color value
     * @param bool             $gray
     * @param Format|string    $format    Image file format
     *
     * @throws \ImagickException
     */
    public static function image($dir = null, $width = 640, $height = 480, $category = null, $fullPath = true, $randomize = true, $word = null, $gray = false, $format = 'png'): string
    {
        return self::img(
            $width,
            $height,
            self::imageTypeToPseudoString($category, $word),
            $format instanceof Format ? $format : Format::from((string) $format)
        )->getImageBlob();
    }

    /**
     * Different image types have different extra variables.
     */
    private static function imageTypeToPseudoString(null|string|Type $imageType, null|float|int|string $arg): string
    {
        // Handles Faker's (deprecated) categories to a default solid color.
        if (null === $imageType) {
            $imageType = Type::SOLID_COLOR;
        } elseif (\is_string($imageType)) {
            $imageType = Type::tryFrom($imageType);
        }

        return match ($imageType) {
            Type::PATTERN => PatternsFormatter::format($imageType, $arg),
            Type::SOLID_COLOR => SolidColorFormatter::format($imageType, $arg),
            Type::RADIAL_GRADIENT, Type::LINEAR_GRADIENT => GradientsFormatter::format($imageType, $arg),
            Type::PLASMA => PlasmaFormatter::format($imageType, $arg),
            default => throw new \UnexpectedValueException('Missing image type category')
        };
    }

    /**
     * @throws \ImagickException
     */
    private static function img(int $width, int $height, string $pseudoString, Format $format): \Imagick
    {
        $image = new \Imagick();
        $image->newPseudoImage($width, $height, $pseudoString);
        $image->setImageFormat($format->value);

        return $image;
    }
}
