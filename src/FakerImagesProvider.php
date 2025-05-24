<?php

declare(strict_types=1);

/**
 * © 2025 Niklas Brunberg
 * SPDX-License-Identifier: AGPL-3.0-only.
 */

namespace NiklasBr\FakerImages;

use Faker\Provider\Image;

final class FakerImagesProvider extends Image
{
    /**
     * @throws \ImagickException
     */
    public static function imageData(
        int $width = 640,
        int $height = 480,
        ImageFormatEnum $format = ImageFormatEnum::PNG,
        ?string $imageType = 'radial-gradient:red-blue',
    ): string {
        return self::img($width, $height, $imageType, $format)->getImageBlob();
    }

    /**
     * @throws \ImagickException
     */
    private static function img(int $width, int $height, string $imageType, ImageFormatEnum $format): \Imagick
    {
        $image = new \Imagick();
        $image->newPseudoImage($width, $height, $imageType);
        $image->setImageFormat($format->value);

        return $image;
    }
}
