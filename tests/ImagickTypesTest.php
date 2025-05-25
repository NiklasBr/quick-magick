<?php

/**
 * © 2025 Niklas Brunberg
 * Licensed under AGPL-3.0-only; BSD-3-Clause available via commercial agreement.
 */

declare(strict_types=1);

namespace NiklasBr\FakerImages\Tests;

use NiklasBr\FakerImages\Enums\Type;
use NiklasBr\FakerImages\FakerImagesProvider;
use NiklasBr\FakerImages\Validator;
use Spatie\Color\Exceptions\InvalidColorValue;

it('writes a default values file to disk', function () {
    $imageData = FakerImagesProvider::image();

    $putResult = file_put_contents(__DIR__.'/default_output.png', $imageData);

    expect($putResult)
        ->not()->toBeFalse()
        ->toEqual(\strlen($imageData))
        ->and(__DIR__.'/default_output.png')->toBeFile()
    ;
});

it('writes a linear gradient image file to disk', function () {
    $imageData = FakerImagesProvider::image(category: Type::LINEAR_GRADIENT, imagickArgs: '#ffC300-magenta');

    $putResult = file_put_contents(__DIR__.'/linear_gradient.png', $imageData);

    expect($putResult)
        ->not()->toBeFalse()
        ->toEqual(\strlen($imageData))
        ->and(__DIR__.'/linear_gradient.png')->toBeFile()
    ;
});

it('creates a two-color gradient image', function () {
    $result = FakerImagesProvider::image(category: Type::LINEAR_GRADIENT, imagickArgs: '#ffC300-magenta');

    /** @var array{0: int<0, max>, 1: int<0, max>, 2: int, 3: string, mime: string, channels?: int, bits?: int} $imgData */
    $imgData = getimagesizefromstring($result);

    expect($imgData)
        ->not()->toBeFalse()
        ->toBeArray()
        ->and($imgData['mime'])->toMatch('/image\/png/')
    ;
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

it('writes a radial gradient image file to disk', function () {
    $imageData = FakerImagesProvider::image(category: Type::RADIAL_GRADIENT, imagickArgs: 'green-yellow');

    $putResult = file_put_contents(__DIR__.'/radial_gradient.png', $imageData);

    expect($putResult)
        ->not()->toBeFalse()
        ->toEqual(\strlen($imageData))
        ->and(__DIR__.'/radial_gradient.png')->toBeFile()
    ;
});

it('writes a pattern image file to disk', function () {
    $imageData = FakerImagesProvider::image(category: Type::PATTERN, imagickArgs: 'SMALLFISHSCALES');

    $putResult = file_put_contents(__DIR__.'/pattern.png', $imageData);

    expect($putResult)
        ->not()->toBeFalse()
        ->toEqual(\strlen($imageData))
        ->and(__DIR__.'/pattern.png')->toBeFile()
    ;
});

it('throws an exception when there is no proper pattern-pattern', function () {
    expect(function () {
        FakerImagesProvider::image(category: Type::PATTERN, imagickArgs: 'BAD PATTERN');
    })->toThrow(\InvalidArgumentException::class);
});

it('writes a plasma image file to disk', function () {
    $imageData = FakerImagesProvider::image(category: Type::PLASMA, imagickArgs: 'fractal-magenta');

    $putResult = file_put_contents(__DIR__.'/plasma.png', $imageData);

    expect($putResult)
        ->not()->toBeFalse()
        ->toEqual(\strlen($imageData))
        ->and(__DIR__.'/plasma.png')->toBeFile()
    ;
});

it('throws an exception when there is no proper plasma-pattern', function () {
    expect(function () {
        FakerImagesProvider::image(category: Type::PLASMA, imagickArgs: 'meatballs');
    })->toThrow(\InvalidArgumentException::class);
});

it('throws an exception when there is no proper plasma-pattern-color', function () {
    expect(function () {
        FakerImagesProvider::image(category: Type::PLASMA, imagickArgs: 'fractal-gesundheit');
    })->toThrow(InvalidColorValue::class);
});
