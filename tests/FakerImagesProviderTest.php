<?php

/**
 * © 2025 Niklas Brunberg
 * Licensed under AGPL-3.0-only; BSD-3-Clause available via commercial agreement.
 */

declare(strict_types=1);

namespace NiklasBr\QuickMagick\Tests;

use Faker\Factory;
use Faker\Provider\Base;
use NiklasBr\QuickMagick\Enums\Category;
use NiklasBr\QuickMagick\Enums\Format;
use NiklasBr\QuickMagick\QuickMagick;
use NiklasBr\QuickMagick\Validators\ColorValidator;
use Spatie\Color\Exceptions\InvalidColorValue;

dataset('invalid colors', [
    'rgb()',                 // Missing all values
    'blåbär',                // Invalid
    'black-nope',            // Invalid combination
    'foo-red',               // Invalid combination
    'rgb(255,255)',          // Missing one value
    'rgba(255,0,0,2)',       // Alpha out of range (should be 0-1)
    '#12345',                // Invalid hex length
    '#GGG',                  // Invalid hex characters
    'red()',                 // Function call, not valid
    'rgb(256,0,0)',          // Value out of range (max 255)
]);

it('registers properly with Faker', function (): void {
    $faker = Factory::create();
    $faker->addProvider(new QuickMagick($faker));

    expect($faker->getProviders())
        ->toBeArray()
        ->toContainOnlyInstancesOf(Base::class)
    ;
});

it('returns image data with default parameters', function (): void {
    $result = QuickMagick::imageData();

    // https://evanhahn.com/worlds-smallest-png/
    expect(\strlen($result))->toBeGreaterThan(8 + 25 + 22 + 12);
});

it('returns an image data URL with default parameters', function (): void {
    $result = QuickMagick::imageUrl();

    expect($result)->toStartWith('data:image/png;base64,');
});

it('returns a deterministic image URL without random fragment when randomize is false', function (): void {
    $result = QuickMagick::imageUrl(randomize: false);

    expect($result)
        ->toStartWith('data:image/png;base64,')
        ->not()->toContain('#')
    ;
});

it('returns a cache-busted image URL when randomize is true', function (): void {
    $result = QuickMagick::imageUrl(randomize: true);

    expect($result)
        ->toStartWith('data:image/png;base64,')
        ->toContain('#')
    ;
});

it('returns an image URL honoring output format', function (): void {
    $result = QuickMagick::imageUrl(randomize: false, format: Format::JPEG);

    expect($result)->toStartWith('data:image/jpeg;base64,');
});

it('returns image data with custom dimensions', function (): void {
    $result = QuickMagick::imageData(width: 91, height: 85);

    /** @phpstan-var array{0: int<0, max>, 1: int<0, max>, 2: int, 3: string, mime: string, channels?: int, bits?: int} $imgData */
    $imgData = getimagesizefromstring($result);

    expect($imgData)
        ->not()->toBeFalse()
        ->toBeArray()
        ->and($imgData[0])->toBe(91)
        ->and($imgData[1])->toBe(85)
        ->and($imgData['mime'])->toMatch('/image\/png/')
    ;
});

it('supports word argument alongside type', function (): void {
    $result = QuickMagick::imageData(category: Category::LINEAR_GRADIENT, word: '#1100ff-magenta');

    /** @var array{0: int<0, max>, 1: int<0, max>, 2: int, 3: string, mime: string, channels?: int, bits?: int} $imgData */
    $imgData = getimagesizefromstring($result);

    expect($imgData)
        ->not()->toBeFalse()
        ->toBeArray()
        ->and($imgData['mime'])->toMatch('/image\/png/')
    ;
});

it('supports type without explicit args using per-type defaults', function (): void {
    $result = QuickMagick::imageData(category: Category::PATTERN, word: 'SMALLFISHSCALES');

    /** @var array{0: int<0, max>, 1: int<0, max>, 2: int, 3: string, mime: string, channels?: int, bits?: int} $imgData */
    $imgData = getimagesizefromstring($result);

    expect($imgData)
        ->not()->toBeFalse()
        ->toBeArray()
        ->and($imgData['mime'])->toMatch('/image\/png/')
    ;
});

it('accepts category by enum value string', function (): void {
    $result = QuickMagick::imageData(category: 'pattern', word: 'SMALLFISHSCALES');

    /** @var array{0: int<0, max>, 1: int<0, max>, 2: int, 3: string, mime: string, channels?: int, bits?: int} $imgData */
    $imgData = getimagesizefromstring($result);

    expect($imgData)
        ->not()->toBeFalse()
        ->toBeArray()
        ->and($imgData['mime'])->toMatch('/image\/png/')
    ;
});

it('accepts category by enum name string', function (): void {
    $result = QuickMagick::imageData(category: 'PATTERN', word: 'SMALLFISHSCALES');

    /** @var array{0: int<0, max>, 1: int<0, max>, 2: int, 3: string, mime: string, channels?: int, bits?: int} $imgData */
    $imgData = getimagesizefromstring($result);

    expect($imgData)
        ->not()->toBeFalse()
        ->toBeArray()
        ->and($imgData['mime'])->toMatch('/image\/png/')
    ;
});

it('supports word with explicit type and format enum', function (): void {
    $result = QuickMagick::imageData(category: Category::PATTERN, word: 'smallfishscales', format: Format::JPEG);

    /** @var array{0: int<0, max>, 1: int<0, max>, 2: int, 3: string, mime: string, channels?: int, bits?: int} $imgData */
    $imgData = getimagesizefromstring($result);

    expect($imgData)
        ->not()->toBeFalse()
        ->toBeArray()
        ->and($imgData['mime'])->toMatch('/image\/jpeg/')
    ;
});

it('supports xc pseudo image type', function (): void {
    $result = QuickMagick::imageData(category: Category::XC, word: '#33aa66');

    /** @var array{0: int<0, max>, 1: int<0, max>, 2: int, 3: string, mime: string, channels?: int, bits?: int} $imgData */
    $imgData = getimagesizefromstring($result);

    expect($imgData)
        ->not()->toBeFalse()
        ->toBeArray()
        ->and($imgData['mime'])->toMatch('/image\/png/')
    ;
});

it('supports label pseudo image type', function (): void {
    $result = QuickMagick::imageData(width: 240, height: 80, category: Category::LABEL, word: 'quick-magick');

    /** @var array{0: int<0, max>, 1: int<0, max>, 2: int, 3: string, mime: string, channels?: int, bits?: int} $imgData */
    $imgData = getimagesizefromstring($result);

    expect($imgData)
        ->not()->toBeFalse()
        ->toBeArray()
        ->and($imgData[0])->toBe(240)
        ->and($imgData[1])->toBe(80)
        ->and($imgData['mime'])->toMatch('/image\/png/')
    ;
});

it('supports caption pseudo image type', function (): void {
    $result = QuickMagick::imageData(width: 300, height: 120, category: Category::CAPTION, word: 'Quick Magick caption test');

    /** @var array{0: int<0, max>, 1: int<0, max>, 2: int, 3: string, mime: string, channels?: int, bits?: int} $imgData */
    $imgData = getimagesizefromstring($result);

    expect($imgData)
        ->not()->toBeFalse()
        ->toBeArray()
        ->and($imgData[0])->toBe(300)
        ->and($imgData[1])->toBe(120)
        ->and($imgData['mime'])->toMatch('/image\/png/')
    ;
});

it('returns a JPEG when requested', function (): void {
    $result = QuickMagick::imageData(format: Format::JPEG);

    /** @var array{0: int<0, max>, 1: int<0, max>, 2: int, 3: string, mime: string, channels?: int, bits?: int} $imgData */
    $imgData = getimagesizefromstring($result);

    expect($imgData)
        ->not()->toBeFalse()
        ->toBeArray()
        ->and($imgData['mime'])->toMatch('/image\/jpeg/')
    ;
});

it('returns a filepath when requested', function (): void {
    $result = QuickMagick::createImageFile(filePath: './', gray: true);

    expect($result)
        ->toContain(\DIRECTORY_SEPARATOR, '.')
        ->toEndWith('.png')
        ->toBeFile($result)
    ;

    unlink($result);

    $result = QuickMagick::createImageFile(filePath: __DIR__);
    expect($result)
        ->toContain(\DIRECTORY_SEPARATOR, '.')
        ->toEndWith('.png')
        ->toStartWith(\DIRECTORY_SEPARATOR)
    ;

    unlink($result);
});

it('creates a file with a filename', function (): void {
    $result = QuickMagick::createImageFile(filePath: 'tests/out/testpng.png');

    expect($result)
        ->toContain(\DIRECTORY_SEPARATOR, '.')
        ->toEndWith('testpng.png')
        ->toBeFile($result)
    ;
});

it('creates a faker-compatible small image file path', function (): void {
    $result = QuickMagick::image(dir: 'tests/out', width: 50, height: 50, fullPath: false, randomize: false, format: Format::JPEG);

    expect($result)
        ->toBe('image_50x50.jpeg')
        ->and('tests/out/'.$result)->toBeFile()
    ;
});

it('creates image file from category-only faker call', function (): void {
    $result = QuickMagick::image(
        dir: 'tests/out',
        category: Category::PATTERN,
        fullPath: true,
        randomize: false,
        word: 'SMALLFISHSCALES',
    );

    expect($result)
        ->toEndWith('image_640x480.png')
        ->toBeFile($result)
    ;
});

it('supports gray image generation mode', function (): void {
    $result = QuickMagick::imageData(gray: true);

    /** @var array{0: int<0, max>, 1: int<0, max>, 2: int, 3: string, mime: string, channels?: int, bits?: int} $imgData */
    $imgData = getimagesizefromstring($result);

    expect($imgData)
        ->not()->toBeFalse()
        ->toBeArray()
        ->and($imgData['mime'])->toMatch('/image\/png/')
    ;
});

it('throws an exception when there is no proper ImageType', function (): void {
    expect(function (): void {
        QuickMagick::imageData(category: Category::UNKNOWN);
    })->toThrow(\UnexpectedValueException::class);
});

it('throws an exception when category string is unsupported', function (): void {
    expect(function (): void {
        QuickMagick::imageData(category: 'not-a-real-category');
    })->toThrow(\InvalidArgumentException::class);
});

it('throws an exception when format is unsupported by Imagick', function (): void {
    expect(function (): void {
        QuickMagick::imageData(format: 'definitely_unsupported');
    })->toThrow(\InvalidArgumentException::class);
});

it('rethrows Imagick exception for non-label/caption pseudo-image failures', function (): void {
    expect(function (): void {
        QuickMagick::imageData(category: Category::MAGICK, word: '/definitely/not/a/real/image/path.png');
    })->toThrow(\ImagickException::class);
});

it('throws an error when it cannot find the directory', function (): void {
    expect(function (): void {
        QuickMagick::createImageFile(filePath: '/should-not-exist');
    })->toThrow(\InvalidArgumentException::class);
});

it('throws an error when it cannot write to the directory', function (): void {
    expect(function (): void {
        QuickMagick::createImageFile(filePath: '/');
    })->toThrow(\InvalidArgumentException::class);
});

it('throws an error when it cannot write an invalid filename', function (): void {
    expect(function (): void {
        QuickMagick::createImageFile(filePath: '/'.\str_repeat('.boom-', 50).'.png');
    })->toThrow(\InvalidArgumentException::class);
});

it('throws runtime exception when writing fails after path validation', function (): void {
    expect(function (): void {
        $tooLongFileName = \str_repeat('a', 300).'.png';

        // On many systems this raises a native warning before writeImageFile throws RuntimeException.
        \set_error_handler(static fn (): bool => true, E_WARNING);

        try {
            QuickMagick::createImageFile(filePath: 'tests/out/'.$tooLongFileName);
        } finally {
            \restore_error_handler();
        }
    })->toThrow(\RuntimeException::class);
});

it('throws an exception when {color} is not proper', function (string $color): void {
    expect(function () use ($color): void {
        ColorValidator::isValidColor($color);
    })->toThrow(InvalidColorValue::class);
})->with('invalid colors');
