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

    public function watermarkPhoto(string $imagePath, ?string $outputPath = null): void
    {
        $img = $this->getImage($imagePath);
        $w = $img->getWidth();
        $h = $img->getHeight();

        $img = $img->text('WATERMARK', $w/2, $h/2, function (Font $font) {
            $font->file(resource_path('fonts/SEGA.ttf'));
            $font->size(600);
            $font->color([255, 255, 255, 0.8]);
            $font->align('center');
            $font->valign('top');
            $font->angle(40);
        });

        $this->storage->saveLocalImage($img, $outputPath ?? $imagePath);
    }

    private function getImage(string $imagePath): \Intervention\Image\Image
    {
        $data = $this->storage->loadPhoto($imagePath);
        return Image::make($data);
    }

}
