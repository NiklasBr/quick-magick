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

dataset('valid colors', [
    '', // Default
    '#5560eb',
    'red-#aaa',
    'fractal-maroon',
]);

dataset('invalid plasma args', [
    'meatballs',
    'fractal-gesundheit',
    'red-fractal',
    'red-catapult',
    'fractal-fractal',
    'wheat-',
]);

dataset('valid plasma color forms', [
    'rgb(42,120,210)',
    'rgba(42,120,210,0.5)',
    'hsl(80,10%,42%)',
    '#AAFF01-#112233',
]);

it('Accepts plasma argument', function (): void {
    $result = QuickMagick::imageData(category: Category::PLASMA);

    /** @var array{0: int<0, max>, 1: int<0, max>, 2: int, 3: string, mime: string, channels?: int, bits?: int} $imgData */
    $imgData = getimagesizefromstring($result);
    expect($imgData)
        ->not()->toBeFalse()
        ->toBeArray()
        ->and($imgData['mime'])->toMatch('/image\/png/')
    ;
});

it('works with normal color string {color}', function (string $color): void {
    $result = QuickMagick::imageData(category: Category::PLASMA, word: $color);

    /** @var array{0: int<0, max>, 1: int<0, max>, 2: int, 3: string, mime: string, channels?: int, bits?: int} $imgData */
    $imgData = getimagesizefromstring($result);
    expect($imgData)
        ->not()->toBeFalse()
        ->toBeArray()
        ->and($imgData['mime'])->toMatch('/image\/png/')
    ;
})->with('valid colors');

it('accepts additional plasma color syntaxes from ImageMagick color grammar {color}', function (string $color): void {
    $result = QuickMagick::imageData(category: Category::PLASMA, word: $color);

    /** @var array{0: int<0, max>, 1: int<0, max>, 2: int, 3: string, mime: string, channels?: int, bits?: int} $imgData */
    $imgData = getimagesizefromstring($result);
    expect($imgData)
        ->not()->toBeFalse()
        ->toBeArray()
        ->and($imgData['mime'])->toMatch('/image\/png/')
    ;
})->with('valid plasma color forms');

it('supports fractal token without explicit color', function (): void {
    $result = QuickMagick::imageData(category: Category::PLASMA, word: 'fractal');

    /** @var array{0: int<0, max>, 1: int<0, max>, 2: int, 3: string, mime: string, channels?: int, bits?: int} $imgData */
    $imgData = getimagesizefromstring($result);
    expect($imgData)
        ->not()->toBeFalse()
        ->toBeArray()
        ->and($imgData['mime'])->toMatch('/image\/png/')
    ;
});

it('throws an exception when {pattern} is not proper', function (string $pattern): void {
    expect(function () use ($pattern): void {
        QuickMagick::imageData(category: Category::PLASMA, word: $pattern);
    })->toThrow(InvalidColorValue::class);
})->with('invalid plasma args');

it('writes a plasma image file to disk', function (): void {
    $imageData = QuickMagick::imageData(category: Category::PLASMA, word: 'fractal-maroon');

    $putResult = file_put_contents(__DIR__.'/out/plasma.png', $imageData);

    expect($putResult)
        ->not()->toBeFalse()
        ->toEqual(\strlen($imageData))
        ->and(__DIR__.'/out/plasma.png')->toBeFile()
    ;
});
