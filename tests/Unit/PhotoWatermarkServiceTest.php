<?php

namespace Tests\Unit;

use App\Services\PhotoWatermarkService;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class PhotoWatermarkServiceTest extends TestCase {

    /* @var PhotoWatermarkService */
    protected $watermarker;

    public function setUp() {
        parent::setUp();
        $this->watermarker = $this->app->make(PhotoWatermarkService::class);
    }

    /** @test */
    public function test_watermark() {
        $sourcePath = 'photo-watermark-service-test/city-unwatermarked.jpg';
        $targetPath = 'city-watermarked.jpg';
        $this->assertTrue(Storage::exists($sourcePath));
        $this->watermarker->watermarkPhoto($sourcePath, $targetPath);
        $this->assertTrue(Storage::exists($targetPath));
    }
}
