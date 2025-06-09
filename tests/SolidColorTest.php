<?php

/**
 * © 2025 Niklas Brunberg
 * Licensed under AGPL-3.0-only; BSD-3-Clause available via commercial agreement.
 */

declare(strict_types=1);

namespace NiklasBr\QuickMagick\Tests;

use NiklasBr\QuickMagick\Enums\Type;
use NiklasBr\QuickMagick\QuickMagick;
use Spatie\Color\Exceptions\InvalidColorValue;

dataset('colors', [
    'red',
    'silver',
    'rgba(123,123,123,0.1)',
    '#AAFF01',
    '#FFBBEE01',
    'hsl(80,10%,42%)',
]);

it('creates a solid color for {color}', function (string $format) {
    $result = QuickMagick::image(imagickArgs: $format);

    /** @var array{0: int<0, max>, 1: int<0, max>, 2: int, 3: string, mime: string, channels?: int, bits?: int} $imgData */
    $imgData = getimagesizefromstring($result);

    expect($imgData)
        ->not()->toBeFalse()
        ->toBeArray()
        ->and($imgData['mime'])->toMatch('/image\/png/')
    ;
})->with('colors');

it('writes a solid image file to disk', function () {
    $imageData = QuickMagick::image(type: Type::SOLID_COLOR);

    $putResult = file_put_contents(__DIR__.'/out/pattern.png', $imageData);

    expect($putResult)
        ->not()->toBeFalse()
        ->toEqual(\strlen($imageData))
        ->and(__DIR__.'/out/pattern.png')->toBeFile()
    ;
});

it('throws an exception when there is no proper color', function () {
    expect(function () {
        QuickMagick::image(type: Type::SOLID_COLOR, imagickArgs: 'towels');
    })->toThrow(InvalidColorValue::class);
});
