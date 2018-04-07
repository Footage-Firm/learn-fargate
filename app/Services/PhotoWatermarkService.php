<?php

namespace App\Services;

use Intervention\Image\Facades\Image;
use Intervention\Image\Imagick\Font;

class PhotoWatermarkService
{

    /* @var PhotoStorageService */
    protected $storage;

    public function __construct(PhotoStorageService $storage) {
        $this->storage = $storage;
    }

    public function watermarkImage(string $imagePath, ?string $outputPath = null): void
    {
        $img = $this->getImage($imagePath);
        $w = $img->getWidth();
        $h = $img->getHeight();

        $img = $img->text('this photo is watermarked', 0, 0, function (Font $font) {
            $font->file(resource_path('fonts/SEGA.ttf'));
            $font->size(24);
            $font->color('#FFF');
            $font->align('center');
            $font->valign('top');
            $font->angle(45);
        });

        $this->storage->saveLocalImage($img, $outputPath ?? $imagePath);
    }

    private function getImage(string $imagePath): \Intervention\Image\Image
    {
        $data = $this->storage->loadPhoto($imagePath);
        return Image::make($data);
    }

}
