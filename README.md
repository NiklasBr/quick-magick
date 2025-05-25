# Image placeholder provider for [Faker](https://github.com/FakerPHP/Faker)

A high-performance placeholder image generator with full test coverage and no network requests to third-party services.

## Installation

Install this Faker provider using [Composer](https://getcomposer.org/):
```shell
composer require niklasbr/faker-images
```


## Example usage

```php
use Faker\Factory;
use NiklasBr\FakerImages\FakerImagesProvider;

$faker = Factory::create();
$faker->addProvider(new FakerImagesProvider($faker));
$imageData = $faker->image();
```

## License

This package is available under two licenses:

- [Affero GPL Version 3, 19 November 2007](LICENSE-AGPL-3.0.md). This is the default license.

- [BSD-3.0 via commercial agreement](LICENSE-Commercial.md) which also includes a limited warranty and promise fitness, available upon donation to charity.
