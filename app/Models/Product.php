<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Multicaret\Acquaintances\Traits\CanBeSubscribed;
use Nicolaslopezj\Searchable\SearchableTrait;
use Rennokki\QueryCache\Traits\QueryCacheable;

class Product extends Model
{
    use CanBeSubscribed;
    use QueryCacheable;
    use HasFactory;
    use SearchableTrait;

    public $cacheFor = 3600;
    public $cacheTags = ['products'];
    public $cachePrefix = 'products_';

    protected static $flushCacheOnUpdate = true;

    protected $fillable = [
        'user_id',
        'name',
        'slug',
        'description',
        'avatar',
        'website',
        'twitter',
        'repo',
        'producthunt',
        'sponsor',
        'launched',
        'launched_at',
    ];
    protected $casts = [
        'launched_at' => 'datetime',
    ];
    protected $searchable = [
        'columns' => [
            'products.slug' => 10,
            'products.name' => 9,
        ],
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function members(): BelongsToMany
    {
        return $this->belongsToMany(User::class)->withTimestamps();
    }

    public function tasks(): HasMany
    {
        return $this->hasMany(Task::class);
    }

    public function productUpdates(): HasMany
    {
        return $this->hasMany(ProductUpdate::class);
    }

    public function webhooks(): HasMany
    {
        return $this->hasMany(Webhook::class);
    }
}
