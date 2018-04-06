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

class TeamRegistrationJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $team;

    /**
     * @param Team $team
     */
    public function __construct(Team $team)
    {
        $this->team = $team;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        Log::info('Registering team.', ['teamName' => $this->team->name]);

        // Get list of files from S3 bucket.
        $files = Storage::disk(config('filesystems.default'))->listContents();

        // For each file in the S3 bucket, generate a watermarkjob and register it.
        collect($files)->each(function($file) {
            Log::debug('Dispatching watermark job.', ['file' => $file]);
            WatermarkJob::dispatch($file);
        });
    }
}
