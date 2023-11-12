<?php

namespace SyntheticRevisions\Events;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class AfterUpdate implements ShouldQueue
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
        if ($this->model->wasRecentlyCreated == false) {
            $jsonData = $this->model->getAttributes();
            unset($jsonData['id'], $jsonData['updated_at'], $jsonData['created_at']);
            $modelData = json_encode($jsonData);

            $total_revision = DB::table($this->revisionTable)->where('model_id', $this->model->id)->count();

            if ($total_revision >= config('synthetic-revisions.max_revision_row')) {
                DB::table($this->revisionTable)->where('model_id', $this->model->id)->orderBy('created_at', 'asc')->limit(1)->delete();
            }

            /**
             * Modify data based on two model
             * remove crated_at due to format issue
             */
            $revision = DB::table($this->revisionTable)->where('model_id', $this->model->id)->latest()->first();
            $revision['data'] = json_decode($revision['data'], true);
            unset($revision['data']['created_at']);
            $revision['data'] = json_encode($revision['data']);

            /**
             * Compare both model data
             */
            if (is_null($revision) || $revision['data'] != $modelData) {
                dispatch(new AfterStore($this->model));
            }
        }
    }
}
