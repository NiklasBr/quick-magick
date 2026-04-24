<?php

/**
 * © 2025 Niklas Brunberg
 * Licensed under AGPL-3.0-only; BSD-3-Clause available via commercial agreement.
 */

declare(strict_types=1);

namespace NiklasBr\QuickMagick\Tests;

use NiklasBr\QuickMagick\Enums\Category;
use NiklasBr\QuickMagick\QuickMagick;
use Spatie\Color\Exceptions\InvalidColorValue;

dataset('colors', [
    'red',                         // Valid simple named color
    'silver',                      // Valid simple named color
    'rgba(123,123,123,0.1)',       // Valid RGB with alpha channel
    '#AAFF01',                     // Valid standard hex
    '#FFBBEE01',                   // Valid standard hex with alpha
    'hsl(80,10%,42%)',             // Valid HSL
    '#f09',                        // 3-digit hex
    'rgb(255,0,153)',              // Standard rgb()
]);

it('creates a solid color for {color}', function (string $format): void {
    $result = QuickMagick::imageData(word: $format);

    /** @var array{0: int<0, max>, 1: int<0, max>, 2: int, 3: string, mime: string, channels?: int, bits?: int} $imgData */
    $imgData = getimagesizefromstring($result);

    expect($imgData)
        ->not()->toBeFalse()
        ->toBeArray()
        ->and($imgData['mime'])->toMatch('/image\/png/')
    ;
})->with('colors');

it('writes a solid image file to disk', function (): void {
    $result = QuickMagick::createImageFile(
        filePath: __DIR__.'/out/solid_color.png',
        category: Category::SOLID_COLOR,
        word: 'maroon',
    );

    expect($result)
        ->toBe(__DIR__.'/out/solid_color.png')
        ->and($result)->toBeFile()
    ;
});

it('throws an exception when there is no proper color', function (): void {
    expect(function (): void {
        QuickMagick::imageData(category: Category::SOLID_COLOR, word: 'towels');
    })->toThrow(InvalidColorValue::class);
});
