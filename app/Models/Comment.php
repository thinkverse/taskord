<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Multicaret\Acquaintances\Traits\CanBeLiked;
use Nicolaslopezj\Searchable\SearchableTrait;
use Rennokki\QueryCache\Traits\QueryCacheable;

class Comment extends Model
{
    use CanBeLiked;
    use QueryCacheable;
    use HasFactory;
    use SearchableTrait;

    public $cacheFor = 3600;
    public $cacheTags = ['comments'];
    public $cachePrefix = 'comments_';

    protected static $flushCacheOnUpdate = true;

    protected $fillable = [
        'user_id',
        'task_id',
        'comment',
        'hidden',
    ];
    protected $searchable = [
        'columns' => [
            'comments.comment' => 10,
        ],
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function task()
    {
        return $this->belongsTo(Task::class);
    }

    public function replies(): HasMany
    {
        return $this->hasMany(CommentReply::class);
    }
}
