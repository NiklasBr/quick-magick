<?php

/**
 * © 2025 Niklas Brunberg
 * Licensed under AGPL-3.0-only; BSD-3-Clause available via commercial agreement.
 */

declare(strict_types=1);

namespace NiklasBr\QuickMagick\Tests;

use NiklasBr\QuickMagick\Enums\Format;
use NiklasBr\QuickMagick\QuickMagick;

dataset('all output formats', Format::all());

it('returns all supported formats', function (): void {
    expect(Format::all())
        ->toBeArray()
        ->toContain(Format::BMP, Format::GIF, Format::JPEG, Format::PNG, Format::TIFF, Format::WEBP)
    ;
});

it('validates supported and unsupported format strings', function (): void {
    expect(Format::isValid('png'))->toBeTrue()
        ->and(Format::isValid('jpeg'))->toBeTrue()
        ->and(Format::isValid('jpg'))->toBeFalse()
        ->and(Format::isValid('nonsense'))->toBeFalse()
    ;
});

it('generates image data for every supported format', function (string $format): void {
    $result = QuickMagick::imageData(format: $format);

    expect($result)->not->toBeEmpty();

    $image = new \Imagick();
    $image->readImageBlob($result);

    expect(strtoupper($image->getImageFormat()))->toBe(strtoupper($format));
})->with('all output formats');
