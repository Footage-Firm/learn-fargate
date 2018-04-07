<?php

namespace App\Jobs;

use App\Services\PhotoStorageService;
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
    public function handle(PhotoStorageService $storage)
    {
        // Injected
        $this->storage = $storage;

        $filePath = $this->filePath;
        $team = $this->team;
        $context = ['filePath' => $filePath, 'teamName' => $team->name];

        // download the source file
        Log::debug('Downloading image.', $context);
        $stream = $this->photoFs->readStream($filePath);
        $localFilePath = 'copied_'.basename($filePath);
        $this->localFs->putStream($localFilePath, $stream);

        // watermark the file locally
        Log::warning('TODO: Watermarking image.', $context);

        // upload to the target directory
        Log::warning('TODO: Uploading image to team directory.', $context);

        // complete the job
        Log::debug('Finished WatermarkJob.', $context);

    }

}
