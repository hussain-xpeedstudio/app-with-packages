<?php

namespace SyntheticRevisions;

use Illuminate\Support\ServiceProvider;
use Illuminate\Database\Eloquent\Builder;
use SyntheticRevisions\Models\CustomCollection;

class SyntheticRevisionsProvider extends ServiceProvider
{
    public function boot()
    {
        Builder::macro('compare', function () {
            $first = [$this->first()];
            $collection = new CustomCollection($first);
            return $collection->compare();
        });

        $this->publishes([
            __DIR__ . '/config/synthetic-revisions.php' => config_path('synthetic-revisions.php'),
        ], 'synthetic-revisions');
    }
}
