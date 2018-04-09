<?php

namespace App\Jobs;

use App\Services\PhotoStorageService;
use App\Services\PhotoWatermarkService;
use App\Team;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\Log;
use League\Flysystem\FileNotFoundException;

class WatermarkJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /* @var string */
    protected $filePath;
    /* @var Team */
    protected $team;
    /* @var PhotoStorageService */
    protected $storage;
    /* @var PhotoWatermarkService */
    protected $watermarker;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(string $filePath, Team $team)
    {
        $this->filePath = $filePath;
        $this->team = $team;
    }

    /**
     * Execute the job.
     *
     * @return void
     * @throws FileNotFoundException
     */
    public function handle(PhotoStorageService $storage, PhotoWatermarkService $watermarker)
    {
        $this->storage = $storage;
        $this->watermarker = $watermarker;

        $filePath = $this->filePath;
        $teamName = $this->team->name;
        $context = ['filePath' => $filePath, 'teamName' => $teamName];

        // download the source file
        Log::debug('Downloading image.', $context);
        $photoPath = $this->storage->downloadPhoto($filePath, basename($filePath));

        // watermark the file locally]
        Log::debug('Watermarking image.', $context);
        $info = pathinfo($photoPath);
        $this->watermarker->watermarkPhoto($photoPath);

        // upload to the target directory
        Log::debug('Uploading image to team directory.', $context);
        $remotePath = 'teams/'.$teamName.'/'.$info['filename'].'_wm.'.$info['extension'];
        $this->storage->uploadPhoto($photoPath, $remotePath);

        // complete the job
        Log::debug('Finished WatermarkJob.', $context);
    }

}
