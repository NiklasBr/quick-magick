# Image placeholder provider for [Faker](https://github.com/FakerPHP/Faker)

A high-performance placeholder image generator with full test coverage and no network requests to third-party services.

![Coverage](.github/badge-coverage.svg "Badge: Code coverage percentage")
![PHPStan](https://img.shields.io/badge/PHPStan-level%2010-brightgreen "Badge: PHP Stan level")
![Dependabot](https://img.shields.io/badge/Dependabot-Enabled-blue?logo=dependabot "Badge: Dependabot active")


## Installation

Install this Faker [provider](https://fakerphp.org/#faker-internals-understanding-providers) using [Composer](https://getcomposer.org/):
```shell
composer require niklasbr/quick-magick
```


## Example usage

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
// A linear gradient
$imageData = $faker->image(category: Type::LINEAR_GRADIENT, word: '#1100ff-magenta');
```
![linear_gradient.png](docs/img/linear_gradient.png "orange-magenta vertical gradient")

```php
// A radial gradient
$imageData = $faker->image(category: Type::RADIAL_GRADIENT, word: 'green-yellow');
```
![linear_gradient.png](docs/img/radial_gradient.png "green-yellow circular gradient")

```php
// A plasma with fractal colour
$imageData = $faker->image(category: Type::PLASMA, word: 'fractal-magenta');
```
![linear_gradient.png](docs/img/plasma.png "cloudy magenta fractal")

```php
// A black and white pattern
$imageData = $faker->image(category: Type::PATTERN, imagickArgs: 'SMALLFISHSCALES');
```
![linear_gradient.png](docs/img/pattern.png "1-bit repeating fish scale pattern")


## License

This package is available under two licenses:

- [Affero GPL Version 3, 19 November 2007](LICENSE-AGPL-3.0.md), this is the default license.

- [BSD-3.0 via commercial agreement](LICENSE-Commercial.md) which also includes a limited warranty and fitness-for-purpose promise, available upon donation to charity.
