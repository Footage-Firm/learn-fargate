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
        $files = Storage::listContents();
        $this->dispatchWatermarkJobs($files);
    }

    private function dispatchWatermarkJobs(array $files): void {
        collect($files)->each(function ($file) {
            $filePath = $file['path'];
            Log::debug('Dispatching watermark job.', ['filePath' => $filePath, 'teamName' => $this->team->name]);
            WatermarkJob::dispatch($filePath, $this->team);
        });
    }
}
