<?php

namespace App\Models;

use CyrildeWit\EloquentViewable\Contracts\Viewable;
use CyrildeWit\EloquentViewable\InteractsWithViews;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Multicaret\Acquaintances\Traits\CanBeLiked;
use Multicaret\Acquaintances\Traits\CanBeSubscribed;
use Rennokki\QueryCache\Traits\QueryCacheable;

class Question extends Model implements Viewable
{
    use InteractsWithViews;
    use CanBeLiked, CanBeSubscribed;
    use QueryCacheable;
    use HasFactory;

    public $cacheFor = 3600;
    public $cacheTags = ['questions'];
    public $cachePrefix = 'questions_';
    protected static $flushCacheOnUpdate = true;
    protected $fillable = [
        'user_id',
        'title',
        'body',
        'patronOnly',
        'hidden',
    ];

    public function user()
    {
        return $this->belongsTo(\App\Models\User::class);
    }

    public function answer()
    {
        return $this->hasMany(\App\Models\Answer::class);
    }
}
