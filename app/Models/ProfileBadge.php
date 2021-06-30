<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Multicaret\Acquaintances\Traits\CanBeSubscribed;
use Nicolaslopezj\Searchable\SearchableTrait;
use Rennokki\QueryCache\Traits\QueryCacheable;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProfileBadge extends Model
{
    use HasFactory;
    use QueryCacheable;
    use SearchableTrait;
    use CanBeSubscribed;

    public $cacheFor = 3600;
    public $cacheTags = ['badges'];
    public $cachePrefix = 'badges_';

    protected static $flushCacheOnUpdate = true;

    protected $fillable = [
        'user_id',
        'title',
        'slug',
        'icon',
        'color',
    ];
    protected $casts = [
        'user_id' => 'integer',
        'title' => 'string',
        'slug' => 'string',
        'icon' => 'string',
        'color' => 'string',
    ];

    /**
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
