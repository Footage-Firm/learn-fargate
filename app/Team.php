<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Team extends Model
{
    protected $guarded = [];

    public function incrementCompletedTasks() {
        DB::update('UPDATE teams SET completed_tasks = completed_tasks + 1 WHERE id = ?', [$this->id]);
    }
}
