<?php

declare(strict_types=1);

/**
 * © 2025 Niklas Brunberg
 * SPDX-License-Identifier: AGPL-3.0-only.
 */

namespace NiklasBr\FakerImages\Tests;

use NiklasBr\FakerImages\FakerImagesProvider;

it('returns image data with default parameters', static function () {
    $result = FakerImagesProvider::imageData();
    expect($result)->not()->toBeNull();
});
