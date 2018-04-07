<?php

namespace App\Jobs;

use App\Team;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use League\Flysystem\FileNotFoundException;

class WatermarkJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /* @string */
    protected $filePath;
    /* @Team */
    protected $team;
    /* @Storage */
    protected $remoteFs;
    /* @Storage */
    protected $localFs;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(string $filePath, Team $team)
    {
        $this->filePath = $filePath;
        $this->team = $team;
        $this->remoteFs = Storage::getDriver();
        $this->localFs = Storage::getDriver('local');
    }

    /**
     * Execute the job.
     *
     * @return void
     * @throws FileNotFoundException
     */
    public function handle()
    {

        $filePath = $this->filePath;
        $team = $this->team;
        $context = ['filePath' => $filePath, 'teamName' => $team->name];

        // download the source file
        Log::debug('Downloading image.', $context);
        $stream = $this->remoteFs->readStream($filePath);
        $this->localFs->putStream('copied_'.basename($filePath), $stream);

        // watermark the file locally
        Log::warning('TODO: Watermarking image.', $context);

        // upload to the target directory
        Log::warning('TODO: Uploading image to team directory.', $context);

        // complete the job
        Log::debug('Finished WatermarkJob.', $context);

    }

}
