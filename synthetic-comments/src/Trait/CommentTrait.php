<?php

namespace SyntheticComments\Trait;

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Config;
use SyntheticComments\Models\Comment;

trait CommentTrait
{

    protected $tableName = '';
    protected $className='';
    public function setupTable()
    {
        $this->tableName = $this->getCommentTableName();
        if (!Schema::hasTable($this->tableName)) {
            Schema::create($this->tableName, function (Blueprint $table) {
                $table->id();
                $table->string('resource');
                $table->string('resource_id');
                $table->string('parent_comment_id');
                $table->longText('body');
                $table->string('type')->default('default');
                $table->longText('visibility');
                $table->unsignedBigInteger('user_id');
                $table->timestamps();
            });
        }
    }

    public function storeComment($data)
    {
        $this->className=class_basename($data['resource'])!=''?class_basename($data['resource']):class_basename(get_class($this));
        $this->setupTable();
        $comment = new Comment();
        $comment->resource =$data['resource']??'';
        $comment->resource_id = $data['resource_id']??'';
        $comment->parent_comment_id =$data['parent_comment_id']??'';
        $comment->body = $data['body']??'';
        $comment->type = $data['type']??'default';
        $comment->visibility = '[user_id:[1,2,3]]'??'';
        $comment->user_id = 1??'';
        $comment->setTable($this->tableName);
        $comment->save();
        return $comment;
    }

    protected function getCommentTableName()
    {
        $prefix = Config::get('synthetic-comments.table_prefix', 'synthetic');
        $modelClassName = Str::snake(Str::plural($this->className));
        return $prefix . '_' . $modelClassName;
    }
    public function baseComment()
    {
        return $this->hasMany(Comment::class, 'resource_id', 'id')->from(config('synthetic-comments.table_prefix') . '_' . $this->table)->SetDatabase();
    }
   
    public function comments(){
        return $this->baseComment()->with('replies')->get();
    }
    public function scopeRepliesOf($query, $id)
    {
        return $query->where('parent_comment_id', $id)->get();
    }
}
