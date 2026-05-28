<?php

/**
 * © 2025 Niklas Brunberg
 * Licensed under AGPL-3.0-only; BSD-3-Clause available via commercial agreement.
 */

declare(strict_types=1);

use Faker\Factory;
use Faker\Generator;
use NiklasBr\QuickMagick\QuickMagick;

function faker(): Generator
{
    static $faker = null;

    if ($faker === null) {
        $faker = Factory::create();
        $faker->addProvider(new QuickMagick($faker));
    }

    return $faker;
}
