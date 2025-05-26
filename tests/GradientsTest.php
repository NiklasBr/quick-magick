<?php

/**
 * © 2025 Niklas Brunberg
 * Licensed under AGPL-3.0-only; BSD-3-Clause available via commercial agreement.
 */

declare(strict_types=1);

namespace NiklasBr\FakerImages\Tests;

use NiklasBr\FakerImages\Enums\Type;
use NiklasBr\FakerImages\FakerImagesProvider;

dataset('valid colors', [
    '', // Default
    '#5560eb',
    'red-#aaa',
    '#ffC300-magenta',
]);

it('works with normal linear single or double color string {color}', function (string $color) {
    $result = FakerImagesProvider::image(category: Type::LINEAR_GRADIENT, imagickArgs: $color);

    /** @var array{0: int<0, max>, 1: int<0, max>, 2: int, 3: string, mime: string, channels?: int, bits?: int} $imgData */
    $imgData = getimagesizefromstring($result);
    expect($imgData)
        ->not()->toBeFalse()
        ->toBeArray()
        ->and($imgData['mime'])->toMatch('/image\/png/')
    ;
})->with('valid colors');

it('works with normal radial single or double color string {color}', function (string $color) {
    $result = FakerImagesProvider::image(category: Type::RADIAL_GRADIENT, imagickArgs: $color);

    /** @var array{0: int<0, max>, 1: int<0, max>, 2: int, 3: string, mime: string, channels?: int, bits?: int} $imgData */
    $imgData = getimagesizefromstring($result);
    expect($imgData)
        ->not()->toBeFalse()
        ->toBeArray()
        ->and($imgData['mime'])->toMatch('/image\/png/')
    ;
})->with('valid colors');

it('writes a linear gradient image file to disk', function () {
    $imageData = FakerImagesProvider::image(category: Type::LINEAR_GRADIENT, imagickArgs: '#ffC300-magenta');

    $putResult = file_put_contents(__DIR__.'/out/linear_gradient.png', $imageData);

    expect($putResult)
        ->not()->toBeFalse()
        ->toEqual(\strlen($imageData))
        ->and(__DIR__.'/out/linear_gradient.png')->toBeFile()
    ;
});

it('writes a radial gradient image file to disk', function () {
    $imageData = FakerImagesProvider::image(category: Type::RADIAL_GRADIENT, imagickArgs: 'green-yellow');

    $putResult = file_put_contents(__DIR__.'/out/radial_gradient.png', $imageData);

    expect($putResult)
        ->not()->toBeFalse()
        ->toEqual(\strlen($imageData))
        ->and(__DIR__.'/out/radial_gradient.png')->toBeFile()
    ;
});
