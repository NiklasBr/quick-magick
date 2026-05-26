<?php

/**
 * © 2025 Niklas Brunberg
 * Licensed under AGPL-3.0-only; BSD-3-Clause available via commercial agreement.
 */

declare(strict_types=1);

namespace NiklasBr\QuickMagick\Tests;

use NiklasBr\QuickMagick\QuickMagick;

it('randomSolidColor generates a valid image file', function (): void {
    $result = QuickMagick::randomSolidColor();

    expect($result)
        ->toBeString()
        ->toBeFile()
    ;

    // Verify it's a valid image
    $imgData = getimagesizefromstring(file_get_contents($result));
    expect($imgData)->not()->toBeFalse();
});

it('randomSolidColor respects custom dimensions', function (): void {
    $width = 800;
    $height = 600;
    $result = QuickMagick::randomSolidColor(width: $width, height: $height);

    $imgData = getimagesizefromstring(file_get_contents($result));
    expect($imgData[0])->toBe($width)
        ->and($imgData[1])->toBe($height);
});

it('randomSolidColor generates different images on multiple calls', function (): void {
    $result1 = QuickMagick::randomSolidColor();
    $result2 = QuickMagick::randomSolidColor();

    $image1 = file_get_contents($result1);
    $image2 = file_get_contents($result2);

    // Files should be different (different colors)
    expect($image1)->not()->toBe($image2);
});

it('randomGradient generates a valid image file', function (): void {
    $result = QuickMagick::randomGradient();

    expect($result)
        ->toBeString()
        ->toBeFile()
    ;

    $imgData = getimagesizefromstring(file_get_contents($result));
    expect($imgData)->not()->toBeFalse();
});

it('randomGradient respects custom dimensions', function (): void {
    $width = 1024;
    $height = 512;
    $result = QuickMagick::randomGradient(width: $width, height: $height);

    $imgData = getimagesizefromstring(file_get_contents($result));
    expect($imgData[0])->toBe($width)
        ->and($imgData[1])->toBe($height);
});

it('randomGradient generates different images on multiple calls', function (): void {
    $result1 = QuickMagick::randomGradient();
    $result2 = QuickMagick::randomGradient();

    $image1 = file_get_contents($result1);
    $image2 = file_get_contents($result2);

    expect($image1)->not()->toBe($image2);
});

it('randomPattern generates a valid image file', function (): void {
    $result = QuickMagick::randomPattern();

    expect($result)
        ->toBeString()
        ->toBeFile()
    ;

    $imgData = getimagesizefromstring(file_get_contents($result));
    expect($imgData)->not()->toBeFalse();
});

it('randomPattern respects custom dimensions', function (): void {
    $width = 512;
    $height = 512;
    $result = QuickMagick::randomPattern(width: $width, height: $height);

    $imgData = getimagesizefromstring(file_get_contents($result));
    expect($imgData[0])->toBe($width)
        ->and($imgData[1])->toBe($height);
});

it('randomPattern generates different images on multiple calls', function (): void {
    $result1 = QuickMagick::randomPattern();
    $result2 = QuickMagick::randomPattern();

    $image1 = file_get_contents($result1);
    $image2 = file_get_contents($result2);

    expect($image1)->not()->toBe($image2);
});

it('randomPlasma generates a valid image file', function (): void {
    $result = QuickMagick::randomPlasma();

    expect($result)
        ->toBeString()
        ->toBeFile()
    ;

    $imgData = getimagesizefromstring(file_get_contents($result));
    expect($imgData)->not()->toBeFalse();
});

it('randomPlasma respects custom dimensions', function (): void {
    $width = 640;
    $height = 480;
    $result = QuickMagick::randomPlasma(width: $width, height: $height);

    $imgData = getimagesizefromstring(file_get_contents($result));
    expect($imgData[0])->toBe($width)
        ->and($imgData[1])->toBe($height);
});

it('randomPlasma generates different images on multiple calls', function (): void {
    $result1 = QuickMagick::randomPlasma();
    $result2 = QuickMagick::randomPlasma();

    $image1 = file_get_contents($result1);
    $image2 = file_get_contents($result2);

    expect($image1)->not()->toBe($image2);
});

it('randomImage generates a valid image file', function (): void {
    $result = QuickMagick::randomImage();

    expect($result)
        ->toBeString()
        ->toBeFile()
    ;

    $imgData = getimagesizefromstring(file_get_contents($result));
    expect($imgData)->not()->toBeFalse();
});

it('randomImage respects custom dimensions', function (): void {
    $width = 300;
    $height = 300;
    $result = QuickMagick::randomImage(width: $width, height: $height);

    $imgData = getimagesizefromstring(file_get_contents($result));
    expect($imgData[0])->toBe($width)
        ->and($imgData[1])->toBe($height);
});

it('randomImage respects custom format', function (): void {
    $result = QuickMagick::randomImage(format: 'jpeg');

    expect($result)->toEndWith('.jpeg');
});

it('randomImage generates different images on multiple calls', function (): void {
    $result1 = QuickMagick::randomImage();
    $result2 = QuickMagick::randomImage();

    $image1 = file_get_contents($result1);
    $image2 = file_get_contents($result2);

    expect($image1)->not()->toBe($image2);
});

it('randomImage can use custom directory', function (): void {
    $customDir = __DIR__.'/out';
    $result = QuickMagick::randomImage(dir: $customDir);

    expect($result)->toStartWith($customDir)
        ->and($result)->toBeFile();
});

it('all convenience methods support width parameter', function (): void {
    $width = 1200;

    $images = [
        QuickMagick::randomSolidColor(width: $width),
        QuickMagick::randomGradient(width: $width),
        QuickMagick::randomPattern(width: $width),
        QuickMagick::randomPlasma(width: $width),
        QuickMagick::randomImage(width: $width),
    ];

    foreach ($images as $imagePath) {
        $imgData = getimagesizefromstring(file_get_contents($imagePath));
        expect($imgData[0])->toBe($width);
    }
});

it('all convenience methods support height parameter', function (): void {
    $height = 900;

    $images = [
        QuickMagick::randomSolidColor(height: $height),
        QuickMagick::randomGradient(height: $height),
        QuickMagick::randomPattern(height: $height),
        QuickMagick::randomPlasma(height: $height),
        QuickMagick::randomImage(height: $height),
    ];

    foreach ($images as $imagePath) {
        $imgData = getimagesizefromstring(file_get_contents($imagePath));
        expect($imgData[1])->toBe($height);
    }
});
