# QuickMagick

A very fast Faker-compatible image placeholder library for PHP. Generate gradients, plasma effects, repeating patterns, solid color canvases, labels, captions, and random image variants without any network requests.

![Coverage](.github/badge-coverage.svg "Badge: Code coverage percentage")
![PHPStan](https://img.shields.io/badge/PHPStan-level%2010-brightgreen "Badge: PHP Stan level")
![Dependabot](https://img.shields.io/badge/Dependabot-Enabled-blue?logo=dependabot "Badge: Dependabot enabled")


## Installation

Install this [Faker provider](https://fakerphp.org/#faker-internals-understanding-providers) with [Composer](https://getcomposer.org/):
```shell
composer require niklasbr/quick-magick
```


## Quick start

Register the QuickMagick Faker provider and generate an image with category-specific arguments.

```php
use Faker\Factory;
use NiklasBr\QuickMagick\QuickMagick;

$faker = Factory::create();
$faker->addProvider(new QuickMagick($faker));
```
```php
// Simple image with only default parameters
$imageData = $faker->image();
```
![default_output.png](docs/img/default_output.png "simple silver image")

```php
// A linear gradient (using mixed colour notation)
$imageData = $faker->image(category: 'LINEAR_GRADIENT', word: '#1100ff-magenta');
```
![linear_gradient.png](docs/img/linear_gradient.png "orange-magenta vertical gradient")


## Faker provider features

QuickMagick adds a Faker-compatible image provider that uses the same API shape as the built-in Faker image provider, with additional image generation options:

- Generate image files directly with `image()`
- Return raw image blob bytes with `imageData()`
- Build data URL:s with `imageUrl()`
- Create and store image files with `createImageFile()`
- Generate random images of a certain style/category with `randomSolidColor()`, `randomGradient()`, `randomPattern()`, `randomPlasma()` and `randomImage()`
- Supports formats `png`, `jpeg`, `gif`, `webp`, `tiff`, `bmp`

## Example categories

The library supports several visual categories and type-specific arguments:

- `SOLID_COLOR` — flat color canvas, chosen with a hex color string like `#2E86AB`
- `LINEAR_GRADIENT` — linear gradient, specified with a color pair like `#667EEA-#764BA2`
- `RADIAL_GRADIENT` — radial gradient, also using paired colors
- `PATTERN` — repeating texture pattern, selected with a pattern token
- `PLASMA` — plasma noise effect, optionally with a seed color
- `LABEL` — single-line text label image
- `CAPTION` — multi-line wrapped text image


## Documentation and examples

Example images and their generation arguments are available in [docs/documentation.md](docs/documentation.md).


## License

This package is available under two licenses:

- [Affero GPL Version 3, 19 November 2007](LICENSE-AGPL-3.0.md), this is the default license.
- [BSD-3-Clause via commercial agreement](LICENSE-Commercial.md), available via donation to charity. Grants a limited warranty and fitness-for-purpose promise.
