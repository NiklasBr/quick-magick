<?php

/**
 * © 2025 Niklas Brunberg
 * Licensed under AGPL-3.0-only; BSD-3-Clause available via commercial agreement.
 */

declare(strict_types=1);

namespace NiklasBr\FakerImages\Tests;

use NiklasBr\FakerImages\FakerImagesProvider;
use NiklasBr\FakerImages\ImagickPatterns\ImagickPatternsFormatter;
use NiklasBr\FakerImages\Type;

it('writes a default values file to disk', function () {
    $imageData = FakerImagesProvider::image();

    $putResult = file_put_contents(__DIR__.'/default_output.png', $imageData);

    expect($putResult)
        ->not()->toBeFalse()
        ->toEqual(\strlen($imageData))
        ->and(__DIR__.'/default_output.png')->toBeFile()
    ;
});

it('writes a linear gradient image file to disk', function () {
    $imageData = FakerImagesProvider::image(category: Type::LINEAR_GRADIENT, word: 'red-blue');

    $putResult = file_put_contents(__DIR__.'/linear_gradient.png', $imageData);

    expect($putResult)
        ->not()->toBeFalse()
        ->toEqual(\strlen($imageData))
        ->and(__DIR__.'/linear_gradient.png')->toBeFile()
    ;
});

it('writes a radial gradient image file to disk', function () {
    $imageData = FakerImagesProvider::image(category: Type::RADIAL_GRADIENT, word: 'green-yellow');

    $putResult = file_put_contents(__DIR__.'/radial_gradient.png', $imageData);

    expect($putResult)
        ->not()->toBeFalse()
        ->toEqual(\strlen($imageData))
        ->and(__DIR__.'/radial_gradient.png')->toBeFile()
    ;
});

it('writes a pattern image file to disk', function () {
    $imageData = FakerImagesProvider::image(category: Type::PATTERN, word: 'SMALLFISHSCALES');

    $putResult = file_put_contents(__DIR__.'/pattern.png', $imageData);

    expect($putResult)
        ->not()->toBeFalse()
        ->toEqual(\strlen($imageData))
        ->and(__DIR__.'/pattern.png')->toBeFile()
    ;
});

it('writes a plasma image file to disk', function () {
    $imageData = FakerImagesProvider::image(category: Type::PLASMA);

    $putResult = file_put_contents(__DIR__.'/plasma.png', $imageData);

    expect($putResult)
        ->not()->toBeFalse()
        ->toEqual(\strlen($imageData))
        ->and(__DIR__.'/plasma.png')->toBeFile()
    ;
});

