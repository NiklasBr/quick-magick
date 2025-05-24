<?php

declare(strict_types=1);

namespace NiklasBr\FakerImages;

use Faker\Provider\Image;

class FakerImagesProvider extends Image
{
    public static function imageData(
        int $width = 640,
        int $height = 480,
        ImageFormatEnum $format = ImageFormatEnum::PNG,
        string $text = null,
        ?string $backgroundColor = null,
        ?string $textColor = null
    )
    {
    }
}
