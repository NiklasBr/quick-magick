<?php

declare(strict_types=1);

namespace tests;

use NiklasBr\FakerImages\FakerImagesProvider;

it('returns image data with default parameters', static function () {
    $result = FakerImagesProvider::imageData();
    expect($result)->not()->toBeNull();
});
