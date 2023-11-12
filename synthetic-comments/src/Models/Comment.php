<?php

namespace SyntheticComments\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use \SyntheticComments\trait\CommentTrait;
use MongoDB\Laravel\Eloquent\Model;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Config;

class Comment extends Model
{
    use HasFactory, CommentTrait;
    protected $fillable = [
        'resource', 'resource_id', 'parent_comment_id', 'body', 'type', 'visibility', 'user_id'
    ];

    public  function setTable($tableName)
    {
        $this->table = $tableName;
    }

    public function scopeSetDatabase($query)
    {
        $this->table = $query->getQuery()->from;
        return $query;
    }
    public function replies()
    {
        return $this->hasMany(Comment::class, 'parent_comment_id', '_id')->from($this->table);
    }
}
