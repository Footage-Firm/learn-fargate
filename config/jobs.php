<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Watermark Job Configuration
    |--------------------------------------------------------------------------
    |
    | Options for the watermark job.
    |
    */

    'watermark' => [
        'numJobs' => env('JOBS_WATERMARK_NUMJOBS', 1000)
    ]

];