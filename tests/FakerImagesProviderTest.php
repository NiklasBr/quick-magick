<?php

/**
 * © 2025 Niklas Brunberg
 * Licensed under AGPL-3.0-only; BSD-3-Clause available via commercial agreement.
 */

declare(strict_types=1);

namespace NiklasBr\FakerImages\Tests;

use Faker\Factory;
use Faker\Provider\Base;
use NiklasBr\FakerImages\Enums\Format;
use NiklasBr\FakerImages\Enums\Type;
use NiklasBr\FakerImages\FakerImagesProvider;
use NiklasBr\FakerImages\Validator;
use Spatie\Color\Exceptions\InvalidColorValue;

it('registers properly with Faker', function () {
    $faker = Factory::create();
    $faker->addProvider(new FakerImagesProvider($faker));

    expect($faker->getProviders())
        ->toBeArray()
        ->toContainOnlyInstancesOf(Base::class)
    ;
});

it('returns image data with default parameters', function () {
    $result = FakerImagesProvider::image();

    // https://evanhahn.com/worlds-smallest-png/
    expect(\strlen($result))->toBeGreaterThan(8 + 25 + 22 + 12);
});

it('returns image data with custom dimensions', function () {
    $result = FakerImagesProvider::image(width: 91, height: 85);

    /** @phpstan-var array{0: int<0, max>, 1: int<0, max>, 2: int, 3: string, mime: string, channels?: int, bits?: int} $imgData */
    $imgData = getimagesizefromstring($result);

    expect($imgData)
        ->not()->toBeFalse()
        ->toBeArray()
        ->and($imgData[0])->toBe(91)
        ->and($imgData[1])->toBe(85)
        ->and($imgData['mime'])->toMatch('/image\/png/')
    ;
});

it('returns a JPEG when requested', function () {
    $result = FakerImagesProvider::image(format: Format::JPG);

    /** @var array{0: int<0, max>, 1: int<0, max>, 2: int, 3: string, mime: string, channels?: int, bits?: int} $imgData */
    $imgData = getimagesizefromstring($result);

    expect($imgData)
        ->not()->toBeFalse()
        ->toBeArray()
        ->and($imgData['mime'])->toMatch('/image\/jpeg/')
    ;
});

it('returns a filepath when requested', function () {
    $result = FakerImagesProvider::image(dir: './');

    expect($result)
        ->toContain(\DIRECTORY_SEPARATOR, '.')
        ->toEndWith('.png')
        ->not()->toStartWith(\DIRECTORY_SEPARATOR)
    ;

    $result = FakerImagesProvider::image(dir: __DIR__);
    expect($result)
        ->toContain(\DIRECTORY_SEPARATOR, '.')
        ->toEndWith('.png')
        ->toStartWith(\DIRECTORY_SEPARATOR)
    ;
});

it('throws an exception when there is no proper ImageType', function () {
    expect(function () {
        FakerImagesProvider::image(category: Type::UNKNOWN);
    })->toThrow(\UnexpectedValueException::class);
});

it('writes a default values file to disk', function () {
    $imageData = FakerImagesProvider::image();

    $putResult = file_put_contents(__DIR__.'/out/default_output.png', $imageData);

    expect($putResult)
        ->not()->toBeFalse()
        ->toEqual(\strlen($imageData))
        ->and(__DIR__.'/out/default_output.png')->toBeFile()
    ;
});

it('throws an error when it cannot fid the directory', function () {
    expect(function () {
        FakerImagesProvider::image(dir: './should-not-exist');
    })->toThrow(\InvalidArgumentException::class);
});

it('throws an exception when there is no proper color', function () {
    expect(function () {
        Validator::isValidColor('rgb()');
    })->toThrow(InvalidColorValue::class)
        ->and(function () {
            Validator::isValidColor('blåbär');
        })->toThrow(InvalidColorValue::class)
        ->and(function () {
            Validator::isValidColor('black-nope');
        })->toThrow(InvalidColorValue::class)
        ->and(function () {
            Validator::isValidColor('foo-red');
        })->toThrow(InvalidColorValue::class)
    ;
});
