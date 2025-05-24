<?php

declare(strict_types=1);

namespace tests;

use NiklasBr\FakerImages\FakerImagesProvider;
use NiklasBr\FakerImages\ImageFormatEnum;

it('returns image data with default parameters', function () {
    $result = FakerImagesProvider::imageData();
    expect($result)->not()->toBeNull();
});

it('returns image data with custom parameters', function () {

    $result = FakerImagesProvider::imageData(
        800,
        600,
        ImageFormatEnum::JPG,
        'Test Image',
        '#ffffff',
        '#000000',
    );

    expect($result)->not()->toBeNull();
});

