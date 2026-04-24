<?php

/**
 * © 2025 Niklas Brunberg
 * Licensed under AGPL-3.0-only; BSD-3-Clause available via commercial agreement.
 */

declare(strict_types=1);

namespace NiklasBr\QuickMagick\Internal;

use NiklasBr\QuickMagick\Enums\Category;
use NiklasBr\QuickMagick\Formatters\Gradients;
use NiklasBr\QuickMagick\Formatters\Patterns;
use NiklasBr\QuickMagick\Formatters\Plasma;
use NiklasBr\QuickMagick\Formatters\SolidColor;
use Spatie\Color\Exceptions\InvalidColorValue;

/**
 * @internal
 */
final class ImageRenderer
{
    /**
     * Convert image category + argument into Imagick pseudo-image string.
     *
     * @throws InvalidColorValue
     */
    public function categoryToPseudoString(?Category $imageType, ?string $arg): string
    {
        return match ($imageType) {
            Category::PATTERN => Patterns::format($imageType, $arg),
            Category::SOLID_COLOR, Category::XC => SolidColor::format($imageType, $arg),
            Category::RADIAL_GRADIENT, Category::LINEAR_GRADIENT => Gradients::format($imageType, $arg),
            Category::PLASMA => Plasma::format($imageType, $arg),
            Category::LABEL, Category::CAPTION, Category::MAGICK, Category::HALD_CUT => "{$imageType->value}:{$arg}",
            Category::UNKNOWN, null => throw new \UnexpectedValueException('Missing image category')
        };
    }

    public function resolveCategory(Category|string|null $category): Category
    {
        if ($category instanceof Category) {
            return $category;
        }

        if (null === $category) {
            return Category::SOLID_COLOR;
        }

        $fromValue = Category::tryFrom($category);
        if (null !== $fromValue) {
            return $fromValue;
        }

        foreach (Category::cases() as $candidate) {
            if (\strtoupper($category) === $candidate->name) {
                return $candidate;
            }
        }

        throw new \InvalidArgumentException("Unsupported category: {$category}");
    }

    /**
     * Create a pseudo-image and apply output format.
     *
     * @throws \ImagickException
     */
    public function img(int $width, int $height, string $format, string $pseudoString): \Imagick
    {
        $imagickFormat = \strtoupper($format);
        if ([] === \Imagick::queryFormats($imagickFormat)) {
            throw new \InvalidArgumentException("Format {$format} is not supported by the current Imagick build");
        }

        $image = new \Imagick();

        try {
            $image->newPseudoImage($width, $height, $pseudoString);
        } catch (\ImagickException $exception) {
            // Some runtimes do not have font/delegate support for label/caption pseudo images.
            if (!\str_starts_with($pseudoString, 'label:') && !\str_starts_with($pseudoString, 'caption:')) {
                throw $exception;
            }

            $image->newPseudoImage($width, $height, 'xc:silver');
        }

        $image->setImageFormat($imagickFormat);
        $image->setFilename(\uniqid()."_{$width}x{$height}.{$format}");

        return $image;
    }

    /**
     * Resolve target path and write image data to disk.
     */
    public function writeImageFile(\Imagick $image, string $filePath): string
    {
        // Resolve relative path to absolute
        $resolvedPath = \realpath($filePath) ?: $filePath;

        // If path is a directory, append the filename
        if (\is_dir($resolvedPath)) {
            if (!\is_writable($resolvedPath)) {
                throw new \InvalidArgumentException("Cannot write to directory {$resolvedPath}");
            }
            $filePath = $resolvedPath.\DIRECTORY_SEPARATOR.$image->getFilename();
        } elseif (!\is_dir($dir = \dirname($resolvedPath)) || !\is_writable($dir)) {
            throw new \InvalidArgumentException("Cannot write image to directory {$dir}");
        } else {
            $filePath = $resolvedPath;
        }

        if (false === \file_put_contents($filePath, $image->getImageBlob())) {
            throw new \RuntimeException("Unable to write image to {$filePath}");
        }

        return $filePath;
    }
}
