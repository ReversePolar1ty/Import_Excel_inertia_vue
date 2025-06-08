<?php

namespace App\Jobs;

use App\Imports\ProjectImport;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Maatwebsite\Excel\Facades\Excel;

class ImportProjectExcelFileJob implements ShouldQueue
{
    use Queueable;

    private $path;

    /**
     * Create a new job instance.
     * @param $path
     */
    public function __construct($path)
    {
        $this->path = $path;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        Excel::import(new ProjectImport(), $this->path, 'public');
    }
}
