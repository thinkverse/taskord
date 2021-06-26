<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Rennokki\QueryCache\Traits\QueryCacheable;

class Oembed extends Model
{
    use QueryCacheable;
    use HasFactory;

    public $cacheFor = 3600;
    public $cacheTags = ['oembeds'];
    public $cachePrefix = 'oembeds_';

    protected static $flushCacheOnUpdate = true;

    public function task(): BelongsTo
    {
        return $this->belongsTo(Task::class);
    }
}
