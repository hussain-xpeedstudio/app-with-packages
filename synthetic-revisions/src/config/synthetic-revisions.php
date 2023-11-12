<?php
return [
    'multiple_database' => true,
    /**
     * Revision table prefix
     */
    'table_prefix' => 'revision',
    /**
     * max number of revision row,
     */
    'max_revision_row' => 20,
    /**
     * User model
     */
    'user_model' => App\Models\User::class,
    'user_column_name' => 'user_id',
    /**
     * model list for dynamic loading
     */
    'config' => [
        'document' => App\Models\Document::class,
    ]
];
