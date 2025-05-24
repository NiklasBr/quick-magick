<?php

/**
 * © 2025 Niklas Brunberg
 * Licensed under AGPL-3.0-only; BSD-3-Clause available via commercial agreement.
 */

declare(strict_types=1);

namespace NiklasBr\FakerImages;

use Faker\Provider\Image;

final class FakerImagesProvider extends Image
{
    /**
     * @throws \ImagickException
     */
    public static function imageData(int $width = 640, int $height = 480, Format $format = Format::PNG, Type $imageType = Type::RADIAL_GRADIENT): string
    {
        $imageType = self::processImageType($imageType);

        return self::img($width, $height, $imageType, $format)->getImageBlob();
    }

    /**
     * @throws \ImagickException
     */
    private static function img(int $width, int $height, string $imageType, Format $format): \Imagick
    {
        $image = new \Imagick();
        $image->newPseudoImage($width, $height, $imageType);
        $image->setImageFormat($format->value);

        return $image;
    }

    /**
     * @throws \UnexpectedValueException
     */
    private static function processImageType(Type $imageType): string
    {
        return match ($imageType) {
            Type::RADIAL_GRADIENT => $imageType->value.':red-blue',
            default => throw new \UnexpectedValueException('Invalid image type'),
        };
    }
}
