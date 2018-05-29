<?php

namespace Tests\Feature;

use App\Jobs\TeamRegistrationJob;
use App\Team;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class TeamApiTest extends TestCase
{

    use WithoutMiddleware;

    public function testCreateTeam()
    {
        $this
            ->json('POST', '/teams', ['teamName' => 'A Testing Team Name'])
            ->assertJsonStructure([
                'name', 'updated_at', 'created_at', 'id'
            ]);
    }
}
