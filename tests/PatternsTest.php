<?php

/**
 * © 2025 Niklas Brunberg
 * Licensed under AGPL-3.0-only; BSD-3-Clause available via commercial agreement.
 */

declare(strict_types=1);

namespace NiklasBr\QuickMagick\Tests;

use NiklasBr\QuickMagick\Enums\Category;
use NiklasBr\QuickMagick\Formatters\Patterns;
use NiklasBr\QuickMagick\QuickMagick;

dataset('valid patterns', Patterns::$validPatterns);

it('creates pattern image for {format}', function (string $format): void {
    $result = QuickMagick::imageData(category: Category::PATTERN, word: $format);

    /** @var array{0: int<0, max>, 1: int<0, max>, 2: int, 3: string, mime: string, channels?: int, bits?: int} $imgData */
    $imgData = getimagesizefromstring($result);

    expect($imgData)
        ->not()->toBeFalse()
        ->toBeArray()
        ->and($imgData['mime'])->toMatch('/image\/png/')
    ;
})->with('valid patterns');

it('writes a pattern image file to disk', function (): void {
    $result = QuickMagick::createImageFile(
        filePath: __DIR__.'/out/pattern.png',
        category: Category::PATTERN,
        word: 'SMALLFISHSCALES',
    );

    expect($result)
        ->toBe(__DIR__.'/out/pattern.png')
        ->and($result)->toBeFile()
    ;
});

it('throws an exception when there is no proper pattern-pattern', function (): void {
    expect(function (): void {
        QuickMagick::imageData(category: Category::PATTERN, word: 'BAD PATTERN');
    })->toThrow(\InvalidArgumentException::class);
});
