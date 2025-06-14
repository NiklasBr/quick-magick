<?php

/**
 * © 2025 Niklas Brunberg
 * Licensed under AGPL-3.0-only; BSD-3-Clause available via commercial agreement.
 */

declare(strict_types=1);

namespace NiklasBr\QuickMagick;

use Faker\Provider\Base;
use NiklasBr\QuickMagick\Enums\Format;
use NiklasBr\QuickMagick\Enums\Type;
use NiklasBr\QuickMagick\Formatters\Gradients;
use NiklasBr\QuickMagick\Formatters\Patterns;
use NiklasBr\QuickMagick\Formatters\Plasma;
use NiklasBr\QuickMagick\Formatters\SolidColor;
use Spatie\Color\Exceptions\InvalidColorValue;

final class QuickMagick extends Base
{
    /**
     * Generates and returns image data.
     *
     * @param null|Type   $type        Any Imagick keyword as available in the Type enum
     * @param null|string $imagickArgs Any primary argument to the Imagick keyword, e.g. color value, required when using Type::PLASMA
     * @param Format      $format      Image file format
     *
     * @return string ImageData or file path if $dir is not null
     *
     * @throws \ImagickException
     * @throws InvalidColorValue
     */
    public static function image(int $width = 640, int $height = 480, ?Type $type = Type::SOLID_COLOR, ?string $imagickArgs = 'silver', Format $format = Format::PNG): string
    {
        $img = self::img(
            $width,
            $height,
            $format,
            self::imageTypeToPseudoString($type, $imagickArgs),
        );

        return $img->getImageBlob();
    }

    /**
     * Generate and store an image on disk.
     *
     * @param null|Type   $type        Any Imagick keyword as available in the Type enum
     * @param null|string $imagickArgs Any primary argument to the Imagick keyword, e.g. color value, required when using Type::PLASMA
     * @param Format      $format      Image file format
     *
     * @return string ImageData or file path if $dir is not null
     *
     * @throws \ImagickException
     * @throws InvalidColorValue
     */
    public static function createImageFile(string $filePath, int $width = 640, int $height = 480, ?Type $type = Type::SOLID_COLOR, ?string $imagickArgs = 'silver', Format $format = Format::PNG): string
    {
        $img = self::img(
            $width,
            $height,
            $format,
            self::imageTypeToPseudoString($type, $imagickArgs),
        );

        // Resolve relative path to absolute
        $resolvedPath = realpath($filePath) ?: $filePath;

        // If path is a directory, append the filename
        if (\is_dir($resolvedPath)) {
            if (!\is_writable($resolvedPath)) {
                throw new \InvalidArgumentException("Cannot write to directory {$resolvedPath}");
            }
            $filePath = $resolvedPath.\DIRECTORY_SEPARATOR.$img->getFilename();
        } elseif (!\is_dir($dir = \dirname($resolvedPath)) || !\is_writable($dir)) {
            throw new \InvalidArgumentException("Cannot write image to directory {$dir}");
        } else {
            $filePath = $resolvedPath;
        }

        \file_put_contents($filePath, $img->getImageBlob());

        return $filePath;
    }

    /**
     * Different image types have different extra variables.
     *
     * @throws InvalidColorValue
     */
    private static function imageTypeToPseudoString(?Type $imageType, ?string $arg): string
    {
        return match ($imageType) {
            Type::PATTERN => Patterns::format($imageType, $arg),
            Type::SOLID_COLOR => SolidColor::format($imageType, $arg),
            Type::RADIAL_GRADIENT, Type::LINEAR_GRADIENT => Gradients::format($imageType, $arg),
            Type::PLASMA => Plasma::format($imageType, $arg),
            default => throw new \UnexpectedValueException('Missing image type category')
        };
    }

    /**
     * @throws \ImagickException
     */
    private static function img(int $width, int $height, Format $format, string $pseudoString): \Imagick
    {
        $image = new \Imagick();
        $image->newPseudoImage($width, $height, $pseudoString);
        $image->setImageFormat($format->value);
        $image->setFilename(\uniqid()."_{$width}x{$height}.{$format->value}");

        return $image;
    }
}
