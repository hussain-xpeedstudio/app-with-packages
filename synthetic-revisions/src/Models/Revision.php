<?php

namespace SyntheticRevisions\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
// use Illuminate\Database\Eloquent\Model;
use MongoDB\Laravel\Eloquent\Model;
use SyntheticRevisions\Models\CustomCollection;

class Revision extends Model
{
    use HasFactory;

    public $revision_table = null;


    protected $fillable = [
        'model_id', 'revision_name', 'revision_date', 'data'
    ];

    public  function setTable($tableName)
    {
        $this->table = $tableName;
    }

    public function newCollection(array $models = [])
    {
        return new CustomCollection($models);
    }

    public function scopeSetDatabase($query)
    {
        $this->table = $query->getQuery()->from;
        return $query;
    }
}
