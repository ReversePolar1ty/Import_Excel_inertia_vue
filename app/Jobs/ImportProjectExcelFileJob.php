<?php

namespace App\Jobs;

use App\Imports\ProjectDynamicImport;
use App\Imports\ProjectImport;
use App\Models\Task;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Maatwebsite\Excel\Facades\Excel;

class ImportProjectExcelFileJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $path;
    private $task;

    /**
     * Create a new job instance.
     * @param $path
     * @param $task
     */
    public function __construct($path, $task)
    {
        $this->path = $path;
        $this->task = $task;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $this->task->type === 1 ? $this->import1() : $this->import2();
        $this->task->update(['status' => Task::STATUS_SUCCESS]);
    }

    public function import1(){
        Excel::import(new ProjectImport($this->task), $this->path, 'public');
    }

    public function import2(){
        Excel::import(new ProjectDynamicImport($this->task), $this->path, 'public');
    }

}
