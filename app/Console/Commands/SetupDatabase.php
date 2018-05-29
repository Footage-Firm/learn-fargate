<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class SetupDatabase extends Command {

    protected $signature = 'db:setup';

    protected $description = 'Initialize the mysql database';

    public function handle() {
        exec("mysql -h 0.0.0.0 -u root -ppassword < docker/db/setup_db.sql", $output);
        $this->comment(implode(PHP_EOL, $output));
    }
}
