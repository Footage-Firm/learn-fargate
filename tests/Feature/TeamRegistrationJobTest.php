<?php

namespace Tests\Feature;

use App\Jobs\TeamRegistrationJob;
use App\Team;
use Tests\TestCase;

class TeamRegistrationJobTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testTeamRegistrationJob()
    {
        $team = factory(Team::class)->create();
        TeamRegistrationJob::dispatch($team);
    }
}
