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
        $context = compact('filePath', 'teamName');

        // download the source file
        Log::debug('Downloading image.', $context);
        $photoPath = $this->storage->downloadPhoto($filePath, basename($filePath));

        // watermark the file locally]
        Log::debug('Watermarking image.', $context);
        $info = pathinfo($photoPath);
        $this->watermarker->watermarkPhoto($photoPath, $teamName);

        // upload to the target directory
        $remotePath = 'teams/'.$teamName.'/'.$info['filename'].$this->generateRandomString(9).'_wm.'.$info['extension'];
        $context['remotePath'] = $remotePath;
        Log::debug('Uploading image to team directory.', $context);
        $this->storage->uploadAndDeletePhoto($photoPath, $remotePath);

        // increment the completed tasks number for the team
        $this->team->incrementCompletedTasks();

        // complete the job
        Log::debug('Finished WatermarkJob.', $context);
    }

    private function generateRandomString($length = 10) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }

}
