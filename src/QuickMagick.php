<?php

/**
 * © 2025 Niklas Brunberg
 * Licensed under AGPL-3.0-only; BSD-3-Clause available via commercial agreement.
 */

declare(strict_types=1);

namespace NiklasBr\QuickMagick;

use Faker\Provider\Base;
use NiklasBr\QuickMagick\Enums\Category;
use NiklasBr\QuickMagick\Enums\Format;
use NiklasBr\QuickMagick\Internal\ImageRenderer;
use Spatie\Color\Exceptions\InvalidColorValue;

final class QuickMagick extends Base
{
    /**
     * Generate and save an image file, returning its path.
     *
     * Matches the Faker image() provider signature.
     *
     * @param null|string          $dir       Target directory; defaults to system temp dir
     * @param int                  $width     Output width in pixels
     * @param int                  $height    Output height in pixels
     * @param null|Category|string $category  Image type enum, enum name, or enum value
     * @param bool                 $fullPath  Return full path when true, basename when false
     * @param bool                 $randomize Use random file name when true
     * @param null|string          $word      Type-specific argument (for example color or pattern name)
     * @param bool                 $gray      Convert final image to grayscale
     * @param string               $format    Output format string (png, jpeg, gif, webp, tiff, bmp)
     *
     * @return string File path or basename depending on $fullPath
     *
     * @throws \ImagickException
     * @throws InvalidColorValue
     */
    public static function image(
        ?string $dir = null,
        int $width = 640,
        int $height = 480,
        Category|string|null $category = null,
        bool $fullPath = true,
        bool $randomize = true,
        ?string $word = null,
        bool $gray = false,
        string $format = Format::PNG,
    ): string {
        $dir = $dir ?? \sys_get_temp_dir();
        $renderer = new ImageRenderer();
        $resolvedCategory = $renderer->resolveCategory($category);
        $fileName = $randomize ? \uniqid('', true) : "image_{$width}x{$height}";
        $targetPath = \rtrim($dir, \DIRECTORY_SEPARATOR).\DIRECTORY_SEPARATOR.$fileName.".{$format}";

        $writtenPath = self::createImageFile(
            filePath: $targetPath,
            width: $width,
            height: $height,
            category: $resolvedCategory,
            word: $word,
            gray: $gray,
            format: $format,
        );

        return $fullPath ? $writtenPath : \basename($writtenPath);
    }

    /**
     * Generate and return raw image blob data.
     *
     * @param int                  $width    Output width in pixels
     * @param int                  $height   Output height in pixels
     * @param null|Category|string $category Image type enum, enum name, or enum value
     * @param null|string          $word     Type-specific argument (for example color or pattern name)
     * @param bool                 $gray     Convert final image to grayscale
     * @param string               $format   Output format string (png, jpeg, gif, webp, tiff, bmp)
     *
     * @return string Raw image blob data
     *
     * @throws \ImagickException
     * @throws InvalidColorValue
     */
    public static function imageData(
        int $width = 640,
        int $height = 480,
        Category|string|null $category = Category::SOLID_COLOR,
        ?string $word = null,
        bool $gray = false,
        string $format = Format::PNG,
    ): string {
        $renderer = new ImageRenderer();
        $resolvedCategory = $renderer->resolveCategory($category);

        $img = $renderer->img(
            $width,
            $height,
            $format,
            $renderer->categoryToPseudoString($resolvedCategory, $word),
        );

        if ($gray) {
            $img->transformImageColorspace(\Imagick::COLORSPACE_GRAY);
        }

        return $img->getImageBlob();
    }

    /**
     * Generate a Faker-compatible image URL string.
     *
     * Returns a data URL that can be used directly as an image source.
     *
     * @param int                  $width     Output width in pixels
     * @param int                  $height    Output height in pixels
     * @param null|Category|string $category  Image type enum, enum name, or enum value
     * @param bool                 $randomize Add a unique fragment for cache busting when true
     * @param null|string          $word      Type-specific argument (for example color or pattern name)
     * @param bool                 $gray      Convert final image to grayscale
     * @param string               $format    Output format string (png, jpeg, gif, webp, tiff, bmp)
     *
     * @throws \ImagickException
     * @throws InvalidColorValue
     */
    public static function imageUrl(
        int $width = 640,
        int $height = 480,
        Category|string|null $category = null,
        bool $randomize = true,
        ?string $word = null,
        bool $gray = false,
        string $format = Format::PNG,
    ): string {
        $blob = self::imageData(
            width: $width,
            height: $height,
            category: $category,
            word: $word,
            gray: $gray,
            format: $format,
        );

        $base64 = \base64_encode($blob);
        $url = "data:image/{$format};base64,{$base64}";

        if ($randomize) {
            return $url.'#'.\uniqid('', true);
        }

        return $url;
    }

    /**
     * Generate and store an image at an explicit file path.
     *
     * @param string               $filePath Destination file path, or writable directory path
     * @param int                  $width    Output width in pixels
     * @param int                  $height   Output height in pixels
     * @param null|Category|string $category Image type enum, enum name, or enum value
     * @param null|string          $word     Type-specific argument (for example color or pattern name)
     * @param bool                 $gray     Convert final image to grayscale
     * @param string               $format   Output format string (png, jpeg, gif, webp, tiff, bmp)
     *
     * @return string Absolute or relative path to the written file
     *
     * @throws \ImagickException
     * @throws InvalidColorValue
     */
    public static function createImageFile(
        string $filePath,
        int $width = 640,
        int $height = 480,
        Category|string|null $category = Category::SOLID_COLOR,
        ?string $word = null,
        bool $gray = false,
        string $format = Format::PNG,
    ): string {
        $renderer = new ImageRenderer();
        $resolvedCategory = $renderer->resolveCategory($category);

        $img = $renderer->img(
            $width,
            $height,
            $format,
            $renderer->categoryToPseudoString($resolvedCategory, $word),
        );

        if ($gray) {
            $img->transformImageColorspace(\Imagick::COLORSPACE_GRAY);
        }

        return $renderer->writeImageFile($img, $filePath);
    }
}
