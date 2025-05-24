<?php

/**
 * © 2025 Niklas Brunberg
 * Licensed under AGPL-3.0-only; BSD-3-Clause available via commercial agreement.
 */

declare(strict_types=1);

namespace NiklasBr\FakerImages\Tests;

use NiklasBr\FakerImages\FakerImagesProvider;
use NiklasBr\FakerImages\Format;
use NiklasBr\FakerImages\Type;

it('returns image data with default parameters', function () {
    $result = FakerImagesProvider::imageData();
    expect($result)->not()->toBeNull();
});

it('throws an exception when there is no proper ImageType', function () {
    expect(function () {
        FakerImagesProvider::imageData(100, 100, Format::PNG, Type::UNKNOWN);
    })->toThrow(\UnexpectedValueException::class);
});
