# Documentation

This document explains how to use QuickMagick’s public methods and what the main input arguments mean. The sections below describe the most commonly used arguments across those methods.

QuickMagick is intended to be used as a Faker provider. Register `new QuickMagick($faker)` with Faker once, and the generated examples below assume the provider is already available on `$faker`.

## `dir` and `filePath`

- `dir` is the target directory where generated image files are written. If omitted, QuickMagick defaults to the system temporary directory.
- `filePath` is the explicit destination path for the generated image. Use this when you need full control over the output filename.

Methods using `dir` include `image()`, `randomSolidColor()`, `randomGradient()`, `randomPattern()`, `randomPlasma()`, and `randomImage()`.

## `width` and `height`

These arguments define the output image dimensions in pixels. Every public image generation method accepts both `width` and `height`.

- `width` controls the horizontal size.
- `height` controls the vertical size.

Use smaller values for lightweight placeholder images and larger values for high-resolution examples.

## `category`

The `category` argument controls the image type and the pseudo-image syntax used by ImageMagick.

QuickMagick accepts:

- a `Category` enum value like `Category::LINEAR_GRADIENT`
- an enum name like `'LINEAR_GRADIENT'`
- a category string value like `'gradient'`

Supported categories include:

- `Category::SOLID_COLOR`
- `Category::LINEAR_GRADIENT`
- `Category::RADIAL_GRADIENT`
- `Category::PATTERN`
- `Category::PLASMA`
- `Category::LABEL`
- `Category::CAPTION`

If `category` is omitted, it defaults to `Category::SOLID_COLOR`.

## `word`

The `word` argument is category-specific and supplies the core pseudo-image parameter.

- `Category::SOLID_COLOR` — a single color such as `#2E86AB`.
- `Category::LINEAR_GRADIENT` and `Category::RADIAL_GRADIENT` — a color pair separated by a hyphen, e.g. `#667EEA-#764BA2`.
- `Category::PATTERN` — a pattern token such as `CROSSHATCH30` or `SMALLFISHSCALES`.
- `Category::PLASMA` — an optional seed color like `#FF006E`; omitting `word` produces a random plasma.
- `Category::LABEL` and `Category::CAPTION` — plain text to render in the image.

ImageMagick supports many color notations, including `#f09`, `#FFBBEE01`, `rgb(255,0,153)`, `rgba(123,123,123,0.1)`, and `hsl(80,10%,42%)`.

## `gray`

The `gray` argument is a boolean flag available on `image()`, `imageData()`, and `createImageFile()`.

When `true`, the generated image is converted to grayscale after rendering.

## `format`

The `format` argument controls the output image format.

Supported formats are defined in `NiklasBr\QuickMagick\Enums\Format`:

- `Format::PNG`
- `Format::JPEG`
- `Format::GIF`
- `Format::WEBP`
- `Format::TIFF`
- `Format::BMP`

Use these constants to ensure consistent output across your calls.

## `fullPath` and `randomize`

These arguments apply to `image()`:

- `fullPath` determines whether the method returns the full path (`true`) or just the file name (`false`).
- `randomize` controls whether the generated filename is unique. Set it to `false` for stable names, or `true` to avoid collisions.

## Convenience random methods

QuickMagick also exposes convenience methods for generating random placeholder content:

- `randomSolidColor()`
- `randomGradient()`
- `randomPattern()`
- `randomPlasma()`
- `randomImage()`

These methods accept `dir`, `width`, `height`, and `format`, and they generate images without requiring you to provide a `category` or `word` value.

{{content_placeholder}}
