<?php

namespace App\Models;

use Rennokki\QueryCache\Traits\QueryCacheable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Nicolaslopezj\Searchable\SearchableTrait;
use Multicaret\Acquaintances\Traits\CanBeSubscribed;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Badge extends Model
{
    use HasFactory;
    use QueryCacheable;
    use SearchableTrait;
    use CanBeSubscribed;

    public $cacheFor = 3600;
    public $cacheTags = ['badges'];
    public $cachePrefix = 'badges_';

    protected static $flushCacheOnUpdate = true;
}
