<?php

namespace SyntheticRevisions\Events;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Bus\Queueable;
use Illuminate\Support\Str;

class AfterDelete implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $model;
    protected $revisionTable;

    public function __construct($model)
    {
        $this->model = $model;
        $this->revisionTable = config('synthetic-revisions.table_prefix') . '_' . Str::snake(Str::plural(class_basename(get_class($model))));
    }

    public function handle()
    {
        $this->model->preSave();
        $this->model->postDelete();
        $this->model->postForceDelete();
    }
}
