<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Multicaret\Acquaintances\Traits\CanBeLiked;
use Multicaret\Acquaintances\Traits\CanBeSubscribed;
use Rennokki\QueryCache\Traits\QueryCacheable;
use Nicolaslopezj\Searchable\SearchableTrait;

class Task extends Model
{
    use CanBeLiked, CanBeSubscribed;
    use QueryCacheable;
    use HasFactory;
    use SearchableTrait;

    public $cacheFor = 3600;
    public $cacheTags = ['tasks'];
    public $cachePrefix = 'tasks_';
    protected static $flushCacheOnUpdate = true;
    protected $fillable = [
        'user_id',
        'product_id',
        'task',
        'done',
        'source',
        'done_at',
        'due_at',
        'images',
        'type',
        'hidden',
    ];

    protected $casts = [
        'images' => 'array',
        'due_at' => 'datetime',
    ];

    protected $searchable = [
        'columns' => [
            'tasks.task' => 10,
        ],
        'joins' => [
            'users' => ['tasks.user_id','users.id'],
        ],
    ];

    public function user()
    {
        return $this->belongsTo(\App\Models\User::class);
    }

    public function comments()
    {
        return $this->hasMany(\App\Models\Comment::class);
    }

    public function product()
    {
        return $this->belongsTo(\App\Models\Product::class);
    }
}
