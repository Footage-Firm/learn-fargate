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

class TeamRegistrationJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /* @var Team */
    protected $team;

    /* @var PhotoStorageService */
    protected $storage;

    /**
     * @param Team $team
     */
    public function __construct(Team $team)
    {
        $this->team = $team;
    }

    /**
     * @param PhotoStorageService $storage
     */
    public function handle(PhotoStorageService $storage)
    {
        $this->storage = $storage;

        Log::info('Registering team.', ['teamName' => $this->team->name]);
        $this->createTeamDirectory();
        $this->dispatchWatermarkJobs();
    }

    private function createTeamDirectory(): void
    {
        $this->storage->createTeamDirectory($this->team->name);
    }

    private function dispatchWatermarkJobs(): void {
        $files = collect($this->storage->listSourcePhotos());
        $numJobs = config('jobs.watermark.numJobs');
        collect(range(1, $numJobs))->each(function ($i) use ($files) {
            $file = $files->random();
            $filePath = $file['path'];
            Log::debug('Dispatching watermark job.', ['filePath' => $filePath, 'teamName' => $this->team->name]);
            WatermarkJob::dispatch($filePath, $this->team)->onQueue($this->team->name);
        });

        // Set total tasks
        $this->team->total_tasks = $numJobs;
        $this->team->save();
    }
}
