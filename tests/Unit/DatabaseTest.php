<?php

namespace Tests\Unit;

use App\Services\PhotoWatermarkService;
use App\Team;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class DatabaseTest extends TestCase {

    use DatabaseMigrations;

    public function testDatabase()
    {
        $team = factory(Team::class)->create();

        $this->assertDatabaseHas('teams', [
            'name' => $team->name
        ]);
    }
}