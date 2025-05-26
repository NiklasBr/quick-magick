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

dataset('valid colors', [
    '', // Default
    '#5560eb',
    'red-#aaa',
]);

dataset('invalid plasma args', [
    'meatballs',
    'fractal-gesundheit',
    'red-fractal',
    'red-catapult',
    'wheat-',
]);

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

it('works with normal color string {color}', function (string $color) {
    $result = FakerImagesProvider::image(category: Type::PLASMA, imagickArgs: $color);

    /** @var array{0: int<0, max>, 1: int<0, max>, 2: int, 3: string, mime: string, channels?: int, bits?: int} $imgData */
    $imgData = getimagesizefromstring($result);
    expect($imgData)
        ->not()->toBeFalse()
        ->toBeArray()
        ->and($imgData['mime'])->toMatch('/image\/png/')
    ;
})->with('valid colors');

it('throws an exception when {pattern} is not proper', function (string $pattern) {
    expect(function () use ($pattern) {
        FakerImagesProvider::image(category: Type::PLASMA, imagickArgs: $pattern);
    })->toThrow(InvalidColorValue::class);
})->with('invalid plasma args');

it('writes a plasma image file to disk', function () {
    $imageData = FakerImagesProvider::image(category: Type::PLASMA, imagickArgs: 'fractal-maroon');

    $putResult = file_put_contents(__DIR__.'/out/plasma.png', $imageData);

    expect($putResult)
        ->not()->toBeFalse()
        ->toEqual(\strlen($imageData))
        ->and(__DIR__.'/out/plasma.png')->toBeFile()
    ;
});
