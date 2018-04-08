<?php

namespace Tests\Unit;

use App\Services\PhotoWatermarkService;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class PhotoWatermarkServiceTest extends TestCase {

    /* @var PhotoWatermarkService */
    protected $photoWatermarkService;

    public function setUp() {
        parent::setUp();
        $this->photoWatermarkService = $this->app->make(PhotoWatermarkService::class);
    }

    /** @test */
    public function test_watermark() {
        $this->photoWatermarkService->watermarkImage('photo.jpg', 'watermarked.jpg');
        $this->assertTrue(Storage::exists('watermarked.jpg'));
    }
}
