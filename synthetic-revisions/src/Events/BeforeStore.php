<?php

namespace SyntheticRevisions\Events;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Bus\Queueable;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

class BeforeStore implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    // protected $model;
    protected $revisionTable;

    public function __construct($model)
    {
        // $this->model = $model;
        $this->revisionTable = config('synthetic-revisions.table_prefix') . '_' . Str::snake(Str::plural(class_basename(get_class($model))));
    }

    public function handle()
    {
        $this->setOrCreateTable($this->revisionTable);
    }

    public function setOrCreateTable($tableName)
    {
        if (!Schema::hasTable($tableName)) {
            Schema::create($tableName, function (Blueprint $table) {
                $table->id();
                $table->string('model_id');
                $table->string('revision_name');
                $table->unsignedBigInteger('user_id');
                $table->dateTime('revision_date');
                $table->longText('data');
                $table->timestamps();
            });
        }

        $this->revisionTable = $tableName;
    }
}
