<?php

/**
 * © 2025 Niklas Brunberg
 * Licensed under AGPL-3.0-only; BSD-3-Clause available via commercial agreement.
 */

declare(strict_types=1);

namespace NiklasBr\QuickMagick\Tests;

use NiklasBr\QuickMagick\Enums\Category;
use NiklasBr\QuickMagick\QuickMagick;

dataset('valid colors', [
    '', // Default
    '#5560eb',
    'red-#aaa',
    '#ffC300-magenta',
]);

it('works with normal linear single or double color string {color}', function (string $color): void {
    $result = QuickMagick::imageData(category: Category::LINEAR_GRADIENT, word: $color);

    /** @var array{0: int<0, max>, 1: int<0, max>, 2: int, 3: string, mime: string, channels?: int, bits?: int} $imgData */
    $imgData = getimagesizefromstring($result);
    expect($imgData)
        ->not()->toBeFalse()
        ->toBeArray()
        ->and($imgData['mime'])->toMatch('/image\/png/')
    ;
})->with('valid colors');

it('works with normal radial single or double color string {color}', function (string $color): void {
    $result = QuickMagick::imageData(category: Category::RADIAL_GRADIENT, word: $color);

    /** @var array{0: int<0, max>, 1: int<0, max>, 2: int, 3: string, mime: string, channels?: int, bits?: int} $imgData */
    $imgData = getimagesizefromstring($result);
    expect($imgData)
        ->not()->toBeFalse()
        ->toBeArray()
        ->and($imgData['mime'])->toMatch('/image\/png/')
    ;
})->with('valid colors');

it('writes a linear gradient image file to disk', function (): void {
    $result = QuickMagick::createImageFile(
        filePath: __DIR__.'/out/linear_gradient.png',
        category: Category::LINEAR_GRADIENT,
        word: '#ffC300-magenta',
    );

    expect($result)
        ->toBe(__DIR__.'/out/linear_gradient.png')
        ->and($result)->toBeFile()
    ;
});

it('writes a radial gradient image file to disk', function (): void {
    $result = QuickMagick::createImageFile(
        filePath: __DIR__.'/out/radial_gradient.png',
        category: Category::RADIAL_GRADIENT,
        word: 'green-yellow',
    );

    expect($result)
        ->toBe(__DIR__.'/out/radial_gradient.png')
        ->and($result)->toBeFile()
    ;
});
