<?php

declare(strict_types=1);

/**
 * © 2025 Niklas Brunberg
 * Licensed under AGPL-3.0-only; BSD-2-Clause available via commercial agreement.
 */

namespace NiklasBr\FakerImages\Tests;

use NiklasBr\FakerImages\FakerImagesProvider;

it('returns image data with default parameters', function () {
    $result = FakerImagesProvider::imageData();
    expect($result)->not()->toBeNull();
});
