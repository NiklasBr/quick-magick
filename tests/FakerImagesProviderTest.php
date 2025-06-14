<?php

/**
 * © 2025 Niklas Brunberg
 * Licensed under AGPL-3.0-only; BSD-3-Clause available via commercial agreement.
 */

declare(strict_types=1);

namespace NiklasBr\QuickMagick\Tests;

use Faker\Factory;
use Faker\Provider\Base;
use NiklasBr\QuickMagick\Enums\Format;
use NiklasBr\QuickMagick\Enums\Type;
use NiklasBr\QuickMagick\QuickMagick;
use NiklasBr\QuickMagick\Validators\ColorValidator;
use Spatie\Color\Exceptions\InvalidColorValue;

dataset('invalid colors', [
    'rgb()',                 // Missing all values
    'blåbär',                // Invalid
    'black-nope',            // Invalid combination
    'foo-red',               // Invalid combination
    'rgb(255,255)',          // Missing one value
    'rgba(255,0,0,2)',       // Alpha out of range (should be 0-1)
    '#12345',                // Invalid hex length
    '#GGG',                  // Invalid hex characters
    'red()',                 // Function call, not valid
    'rgb(256,0,0)',          // Value out of range (max 255)
]);

it('registers properly with Faker', function () {
    $faker = Factory::create();
    $faker->addProvider(new QuickMagick($faker));

    expect($faker->getProviders())
        ->toBeArray()
        ->toContainOnlyInstancesOf(Base::class)
    ;
});

it('returns image data with default parameters', function () {
    $result = QuickMagick::image();

    // https://evanhahn.com/worlds-smallest-png/
    expect(\strlen($result))->toBeGreaterThan(8 + 25 + 22 + 12);
});

it('returns image data with custom dimensions', function () {
    $result = QuickMagick::image(width: 91, height: 85);

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
    $result = QuickMagick::image(format: Format::JPG);

    /** @var array{0: int<0, max>, 1: int<0, max>, 2: int, 3: string, mime: string, channels?: int, bits?: int} $imgData */
    $imgData = getimagesizefromstring($result);

    expect($imgData)
        ->not()->toBeFalse()
        ->toBeArray()
        ->and($imgData['mime'])->toMatch('/image\/jpeg/')
    ;
});

it('returns a filepath when requested', function () {
    $result = QuickMagick::createImageFile(filePath: './');

    expect($result)
        ->toContain(\DIRECTORY_SEPARATOR, '.')
        ->toEndWith('.png')
        ->toBeFile($result)
    ;

    unlink($result);

    $result = QuickMagick::createImageFile(filePath: __DIR__);
    expect($result)
        ->toContain(\DIRECTORY_SEPARATOR, '.')
        ->toEndWith('.png')
        ->toStartWith(\DIRECTORY_SEPARATOR)
    ;

    unlink($result);
});

it('throws an exception when there is no proper ImageType', function () {
    expect(function () {
        QuickMagick::image(type: Type::UNKNOWN);
    })->toThrow(\UnexpectedValueException::class);
});

it('throws an error when it cannot fid the directory', function () {
    expect(function () {
        QuickMagick::createImageFile(filePath: '/should-not-exist');
    })->toThrow(\InvalidArgumentException::class);
});

it('throws an exception when {color} is not proper', function (string $color) {
    expect(function () use ($color) {
        ColorValidator::isValidColor($color);
    })->toThrow(InvalidColorValue::class);
})->with('invalid colors');
