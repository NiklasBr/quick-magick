<?php

/**
 * © 2025 Niklas Brunberg
 * Licensed under AGPL-3.0-only; BSD-3-Clause available via commercial agreement.
 */

declare(strict_types=1);

namespace NiklasBr\QuickMagick\Tests;

use Faker\Factory;
use NiklasBr\QuickMagick\QuickMagick;

it('randomSolidColor generates a valid image file', function (): void {
    $result = faker()->randomSolidColor();

    expect($result)
        ->toBeString()
        ->toBeFile()
    ;

    // Verify it's a valid image
    $contents = file_get_contents($result);
    \assert(\is_string($contents));
    $imgData = getimagesizefromstring($contents);
    expect($imgData)->not()->toBeFalse();
});

it('randomSolidColor respects custom dimensions', function (): void {
    $width = 800;
    $height = 600;
    $result = faker()->randomSolidColor(width: $width, height: $height);

    $contents = file_get_contents($result);
    \assert(\is_string($contents));
    $imgData = getimagesizefromstring($contents);
    \assert(\is_array($imgData));
    expect($imgData[0])->toBe($width)
        ->and($imgData[1])->toBe($height)
    ;
});

it('randomSolidColor generates different images on multiple calls', function (): void {
    $result1 = faker()->randomSolidColor();
    $result2 = faker()->randomSolidColor();

    $image1 = file_get_contents($result1);
    $image2 = file_get_contents($result2);

    // Files should be different (different colors)
    expect($image1)->not()->toBe($image2);
});

it('randomGradient generates a valid image file', function (): void {
    $result = faker()->randomGradient();

    expect($result)
        ->toBeString()
        ->toBeFile()
    ;

    $contents = file_get_contents($result);
    \assert(\is_string($contents));
    $imgData = getimagesizefromstring($contents);
    expect($imgData)->not()->toBeFalse();
});

it('randomGradient respects custom dimensions', function (): void {
    $width = 1_024;
    $height = 512;
    $result = faker()->randomGradient(width: $width, height: $height);

    $contents = file_get_contents($result);
    \assert(\is_string($contents));
    $imgData = getimagesizefromstring($contents);
    \assert(\is_array($imgData));
    expect($imgData[0])->toBe($width)
        ->and($imgData[1])->toBe($height)
    ;
});

it('randomGradient generates different images on multiple calls', function (): void {
    $result1 = faker()->randomGradient();
    $result2 = faker()->randomGradient();

    $image1 = file_get_contents($result1);
    $image2 = file_get_contents($result2);

    expect($image1)->not()->toBe($image2);
});

it('randomPattern generates a valid image file', function (): void {
    $result = faker()->randomPattern();

    expect($result)
        ->toBeString()
        ->toBeFile()
    ;

    $contents = file_get_contents($result);
    \assert(\is_string($contents));
    $imgData = getimagesizefromstring($contents);
    expect($imgData)->not()->toBeFalse();
});

it('randomPattern respects custom dimensions', function (): void {
    $width = 512;
    $height = 512;
    $result = faker()->randomPattern(width: $width, height: $height);

    $contents = file_get_contents($result);
    \assert(\is_string($contents));
    $imgData = getimagesizefromstring($contents);
    \assert(\is_array($imgData));
    expect($imgData[0])->toBe($width)
        ->and($imgData[1])->toBe($height)
    ;
});

it('randomPattern generates different images on multiple calls', function (): void {
    $result1 = faker()->randomPattern();
    $result2 = faker()->randomPattern();

    $image1 = file_get_contents($result1);
    $image2 = file_get_contents($result2);

    expect($image1)->not()->toBe($image2);
});

it('randomPlasma generates a valid image file', function (): void {
    $result = faker()->randomPlasma();

    expect($result)
        ->toBeString()
        ->toBeFile()
    ;

    $contents = file_get_contents($result);
    \assert(\is_string($contents));
    $imgData = getimagesizefromstring($contents);
    expect($imgData)->not()->toBeFalse();
});

it('randomPlasma respects custom dimensions', function (): void {
    $width = 640;
    $height = 480;
    $result = faker()->randomPlasma(width: $width, height: $height);

    $contents = file_get_contents($result);
    \assert(\is_string($contents));
    $imgData = getimagesizefromstring($contents);
    \assert(\is_array($imgData));
    expect($imgData[0])->toBe($width)
        ->and($imgData[1])->toBe($height)
    ;
});

it('randomPlasma generates different images on multiple calls', function (): void {
    $result1 = faker()->randomPlasma();
    $result2 = faker()->randomPlasma();

    $image1 = file_get_contents($result1);
    $image2 = file_get_contents($result2);

    expect($image1)->not()->toBe($image2);
});

it('randomImage generates a valid image file', function (): void {
    $result = faker()->randomImage();

    expect($result)
        ->toBeString()
        ->toBeFile()
    ;

    $contents = file_get_contents($result);
    \assert(\is_string($contents));
    $imgData = getimagesizefromstring($contents);
    expect($imgData)->not()->toBeFalse();
});

it('randomImage respects custom dimensions', function (): void {
    $width = 300;
    $height = 300;
    $result = faker()->randomImage(width: $width, height: $height);

    $contents = file_get_contents($result);
    \assert(\is_string($contents));
    $imgData = getimagesizefromstring($contents);
    \assert(\is_array($imgData));
    expect($imgData[0])->toBe($width)
        ->and($imgData[1])->toBe($height)
    ;
});

it('randomImage respects custom format', function (): void {
    $result = faker()->randomImage(format: 'jpeg');

    expect($result)->toEndWith('.jpeg');
});

it('randomImage generates different images on multiple calls', function (): void {
    $result1 = faker()->randomImage();
    $result2 = faker()->randomImage();

    $image1 = file_get_contents($result1);
    $image2 = file_get_contents($result2);

    expect($image1)->not()->toBe($image2);
})->flaky(3);

it('randomImage can use custom directory', function (): void {
    $customDir = __DIR__.'/out';
    $result = faker()->randomImage(dir: $customDir);

    expect($result)->toStartWith($customDir)
        ->and($result)->toBeFile()
    ;
});

it('all convenience methods support width parameter', function (): void {
    $width = 1_200;

    $images = [
        faker()->randomSolidColor(width: $width),
        faker()->randomGradient(width: $width),
        faker()->randomPattern(width: $width),
        faker()->randomPlasma(width: $width),
        faker()->randomImage(width: $width),
    ];

    foreach ($images as $imagePath) {
        $contents = file_get_contents($imagePath);
        \assert(\is_string($contents));
        $imgData = getimagesizefromstring($contents);
        \assert(\is_array($imgData));
        expect($imgData[0])->toBe($width);
    }
});

it('all convenience methods support height parameter', function (): void {
    $height = 900;

    $images = [
        faker()->randomSolidColor(height: $height),
        faker()->randomGradient(height: $height),
        faker()->randomPattern(height: $height),
        faker()->randomPlasma(height: $height),
        faker()->randomImage(height: $height),
    ];

    foreach ($images as $imagePath) {
        $contents = file_get_contents($imagePath);
        \assert(\is_string($contents));
        $imgData = getimagesizefromstring($contents);
        \assert(\is_array($imgData));
        expect($imgData[1])->toBe($height);
    }
});
