<?php

namespace SyntheticComments;

use Illuminate\Support\ServiceProvider;
use Illuminate\Database\Eloquent\Builder;
use SyntheticComments\Models\CustomCollection;

class SyntheticCommentsProvider extends ServiceProvider
{
    public function boot()
    {

        $this->publishes([
            __DIR__ . '/config/synthetic-comments.php' => config_path('synthetic-comments.php'),
        ], 'synthetic-comments');

        
    }
}
