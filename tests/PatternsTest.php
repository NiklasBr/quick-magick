<?php

/**
 * © 2025 Niklas Brunberg
 * Licensed under AGPL-3.0-only; BSD-3-Clause available via commercial agreement.
 */

declare(strict_types=1);

namespace NiklasBr\QuickMagick\Tests;

use NiklasBr\QuickMagick\Enums\Type;
use NiklasBr\QuickMagick\Formatters\Patterns;
use NiklasBr\QuickMagick\QuickMagick;

dataset('patterns', Patterns::getValidPatterns());

it('creates pattern image for {format}', function (string $format) {
    $result = QuickMagick::image(type: Type::PATTERN, imagickArgs: $format);

    /** @var array{0: int<0, max>, 1: int<0, max>, 2: int, 3: string, mime: string, channels?: int, bits?: int} $imgData */
    $imgData = getimagesizefromstring($result);

    expect($imgData)
        ->not()->toBeFalse()
        ->toBeArray()
        ->and($imgData['mime'])->toMatch('/image\/png/')
    ;
})->with('patterns');

it('writes a pattern image file to disk', function () {
    $imageData = QuickMagick::image(type: Type::PATTERN, imagickArgs: 'SMALLFISHSCALES');

    $putResult = file_put_contents(__DIR__.'/out/pattern.png', $imageData);

    expect($putResult)
        ->not()->toBeFalse()
        ->toEqual(\strlen($imageData))
        ->and(__DIR__.'/out/pattern.png')->toBeFile()
    ;
});

it('throws an exception when there is no proper pattern-pattern', function () {
    expect(function () {
        QuickMagick::image(type: Type::PATTERN, imagickArgs: 'BAD PATTERN');
    })->toThrow(\InvalidArgumentException::class);
});
