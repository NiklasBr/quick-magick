<?php

/**
 * © 2025 Niklas Brunberg
 * Licensed under AGPL-3.0-only; BSD-3-Clause available via commercial agreement.
 */

declare(strict_types=1);

namespace NiklasBr\QuickMagick\Tests;

use NiklasBr\QuickMagick\Enums\Category;
use NiklasBr\QuickMagick\Enums\Patterns;
use NiklasBr\QuickMagick\QuickMagick;

it('creates pattern image for {format}', function (string $format): void {
    $result = faker()->imageData(category: Category::PATTERN, word: $format);

    /** @var array{0: int<0, max>, 1: int<0, max>, 2: int, 3: string, mime: string, channels?: int, bits?: int} $imgData */
    $imgData = getimagesizefromstring($result);

    expect($imgData)
        ->not()->toBeFalse()
        ->toBeArray()
        ->and($imgData['mime'])->toMatch('/image\/png/')
    ;
})->with(Patterns::all());

it('writes a pattern image file to disk', function (): void {
    $result = faker()->createImageFile(
        filePath: __DIR__.'/out/pattern.png',
        category: Category::PATTERN,
        word: Patterns::VERTICALSAW,
    );

    expect($result)
        ->toBe(__DIR__.'/out/pattern.png')
        ->and($result)->toBeFile()
    ;
});

it('throws an exception when there is no proper pattern-pattern', function (): void {
    expect(function (): void {
        faker()->imageData(category: Category::PATTERN, word: 'BAD PATTERN');
    })->toThrow(\InvalidArgumentException::class);
});

it('returns all supported patterns', function (): void {
    expect(Patterns::all())
        ->toBeArray()
        // Test some known patterns to ensure they are included in the list
        ->toContain(Patterns::BRICKS)
        ->toContain(Patterns::GRAY75)
        ->toContain(Patterns::HEXAGONS)
        ->toContain(Patterns::VERTICALSAW)
    ;
});

it('accepts category as string name', function (): void {
    $result = faker()->imageData(category: 'PATTERN', word: Patterns::BRICKS);

    expect($result)->not->toBeEmpty();
});

it('accepts category as string value', function (): void {
    $result = faker()->imageData(category: 'pattern', word: Patterns::BRICKS);

    expect($result)->not->toBeEmpty();
});

it('throws exception for invalid category string', function (): void {
    expect(function (): void {
        faker()->imageData(category: 'INVALID_CATEGORY');
    })->toThrow(\InvalidArgumentException::class);
});

it('defaults to solid color when category is null', function (): void {
    $result = faker()->imageData(category: null);

    expect($result)->not->toBeEmpty();
});
