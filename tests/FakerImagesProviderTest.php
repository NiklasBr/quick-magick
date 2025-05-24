<?php

declare(strict_types=1);

/**
 * © 2025 Niklas Brunberg
 * Available under commercial license or AGPL-3.0-only
 */

namespace NiklasBr\FakerImages\Tests;

use NiklasBr\FakerImages\FakerImagesProvider;

it('returns image data with default parameters', function () {
    $result = FakerImagesProvider::imageData();
    expect($result)->not()->toBeNull();
});
