<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
// use Illuminate\Database\Eloquent\Model;
use \SyntheticRevisions\trait\RevisionableTrait;
use \SyntheticComments\Trait\CommentTrait;
use MongoDB\Laravel\Eloquent\Model;
// use SyntheticFilters\Traits\FilterTrait;

class Document extends Model
{
    use HasFactory, RevisionableTrait, CommentTrait;

    protected $fillable = [
        'name', 'description', 'user_id'
    ];

    public  $filterableAttributes = [
        'name' => [
            'type' => 'text',
            'label' => 'Employee Name',
            'model' => Document::class,
        ],
        'designation' => [
            'type' => 'select',
            'label' => 'Designation',
            'model' => Document::class,
            'isMultiSelect' => 1
        ],
        'role' => [
            'type' => 'select',
            'label' => 'Role',
            'isMultiSelect' => 1,
        ],
        'category' => [
            'type' => 'select',
            'label' => 'Category',
            'isMultiSelect' => 1,
        ]
    ];
}
