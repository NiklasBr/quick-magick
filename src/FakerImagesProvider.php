<?php

/**
 * © 2025 Niklas Brunberg
 * Licensed under AGPL-3.0-only; BSD-3-Clause available via commercial agreement.
 */

declare(strict_types=1);

namespace NiklasBr\FakerImages;

use Faker\Provider\Base;
use NiklasBr\FakerImages\Enums\Format;
use NiklasBr\FakerImages\Enums\Type;
use NiklasBr\FakerImages\Patterns\GradientsFormatter;
use NiklasBr\FakerImages\Patterns\PatternsFormatter;
use NiklasBr\FakerImages\Patterns\PlasmaFormatter;
use NiklasBr\FakerImages\Patterns\SolidColorFormatter;
use Spatie\Color\Exceptions\InvalidColorValue;

final class FakerImagesProvider extends Base
{
    /**
     * @param null|Type   $category    Any Imagick keyword as available in the Type enum
     * @param null|string $imagickArgs Any primary argument to the Imagick keyword, e.g. color value, required when using Type::PLASMA
     * @param Format      $format      Image file format
     *
     * @return string ImageData or file path if $dir is not null
     *
     * @throws \ImagickException
     * @throws InvalidColorValue
     */
    public static function image(?string $dir = null, int $width = 640, int $height = 480, ?Type $category = Type::SOLID_COLOR, bool $fullPath = true, bool $randomize = true, ?string $imagickArgs = 'silver', Format $format = Format::PNG): string
    {
        $img = self::img(
            $width,
            $height,
            self::imageTypeToPseudoString($category, $imagickArgs, $randomize),
            $format
        );

        if (null === $dir) {
            return $img->getImageBlob();
        }

        if (!is_dir($dir) || !is_writable($dir)) {
            throw new \InvalidArgumentException(\sprintf('Cannot write to directory "%s"', $dir));
        }

        return $fullPath
            ? $dir.\DIRECTORY_SEPARATOR.$img->getFilename()
            : $img->getFilename();
    }

    /**
     * Different image types have different extra variables.
     *
     * @throws InvalidColorValue
     */
    private static function imageTypeToPseudoString(?Type $imageType, ?string $arg, bool $randomize): string
    {
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
