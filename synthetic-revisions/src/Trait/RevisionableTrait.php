<?php

namespace SyntheticRevisions\Trait;

use SyntheticRevisions\Events\AfterDelete;
use SyntheticRevisions\Events\AfterStore;
use SyntheticRevisions\Events\AfterUpdate;
use SyntheticRevisions\Events\BeforeStore;
use SyntheticRevisions\Models\Revision;

trait RevisionableTrait
{
    /**
     * revision table name
     */
    public $revisionTable = null;

    public $modelData = false;

    public static function boot()
    {
        parent::boot();

        static::saving(fn ($model) => dispatch(new BeforeStore($model)));
        static::created(fn ($model) => dispatch(new AfterStore($model)));

        static::saved(function ($model) {
            if ($model->wasRecentlyCreated == false) {
                dispatch(new AfterUpdate($model));
            }
        });

        static::deleted(fn ($model) => dispatch(new AfterDelete($model)));
    }

    public function revisions()
    {
        return $this->hasMany(Revision::class, 'model_id', 'id')->from(config('synthetic-revisions.table_prefix') . '_' . $this->table)->SetDatabase();
    }
}
