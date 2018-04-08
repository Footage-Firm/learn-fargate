<?php

namespace Tests\Unit;

use App\Services\PhotoWatermarkService;
use App\Team;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class DatabaseTest extends TestCase {

    public function testDatabase()
    {
        $conf = \DB::getConfig();
        $team = factory(Team::class)->create();

        $this->assertDatabaseHas('teams', [
            'name' => $team->name
        ]);
    }
}