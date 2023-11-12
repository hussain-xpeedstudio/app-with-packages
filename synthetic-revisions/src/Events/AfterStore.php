<?php

namespace SyntheticRevisions\Events;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Bus\Queueable;
use Illuminate\Support\Str;
use SyntheticRevisions\Models\Revision;
use Illuminate\Support\Carbon;

class AfterStore implements ShouldQueue
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
        $jsonData = $this->model->getAttributes();
        unset($jsonData['id'], $jsonData['updated_at']);

        $jsonData['created_at'] = $jsonData['created_at']->toDateTime()->format('Y-m-d\TH:i:s.uP');

        $revision = new Revision();
        $revision->setTable($this->revisionTable);

        $revision->model_id = $this->model->id;
        $revision->revision_name = date('Y-m-d H:i:s');
        $revision->user_id = $this->model->user_id;
        $revision->revision_date = date('Y-m-d H:i:s');
        $revision->data = json_encode($jsonData);
        $revision->save();
    }
}
