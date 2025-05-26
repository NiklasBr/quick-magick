<?php

/**
 * © 2025 Niklas Brunberg
 * Licensed under AGPL-3.0-only; BSD-3-Clause available via commercial agreement.
 */

declare(strict_types=1);

namespace NiklasBr\FakerImages\Tests;

use NiklasBr\FakerImages\Enums\Type;
use NiklasBr\FakerImages\FakerImagesProvider;
use Spatie\Color\Exceptions\InvalidColorValue;

it('Accepts plasma argument', function () {
    $result = FakerImagesProvider::image(category: Type::PLASMA);

    /** @var array{0: int<0, max>, 1: int<0, max>, 2: int, 3: string, mime: string, channels?: int, bits?: int} $imgData */
    $imgData = getimagesizefromstring($result);
    expect($imgData)
        ->not()->toBeFalse()
        ->toBeArray()
        ->and($imgData['mime'])->toMatch('/image\/png/')
    ;
});

it('throws an exception when there is no proper plasma-pattern', function () {
    expect(function () {
        FakerImagesProvider::image(category: Type::PLASMA, imagickArgs: 'meatballs');
    })->toThrow(InvalidColorValue::class);
});

it('throws an exception when there is no proper plasma-pattern-color', function () {
    expect(function () {
        FakerImagesProvider::image(category: Type::PLASMA, imagickArgs: 'fractal-gesundheit');
    })->toThrow(InvalidColorValue::class)
        ->and(function () {
            FakerImagesProvider::image(category: Type::PLASMA, imagickArgs: 'fractal-red-catapult');
        })->toThrow(InvalidColorValue::class)
    ;
});

it('writes a plasma image file to disk', function () {
    $imageData = FakerImagesProvider::image(category: Type::PLASMA, imagickArgs: 'fractal-maroon');

    $putResult = file_put_contents(__DIR__.'/out/plasma.png', $imageData);

    expect($putResult)
        ->not()->toBeFalse()
        ->toEqual(\strlen($imageData))
        ->and(__DIR__.'/out/plasma.png')->toBeFile()
    ;
});
