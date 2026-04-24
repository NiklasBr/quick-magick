<?php

/**
 * © 2025 Niklas Brunberg
 * Licensed under AGPL-3.0-only; BSD-3-Clause available via commercial agreement.
 */

declare(strict_types=1);

namespace NiklasBr\QuickMagick\Tests;

use NiklasBr\QuickMagick\Enums\Format;

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
