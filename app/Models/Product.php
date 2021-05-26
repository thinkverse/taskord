<?php

namespace App\Models;

use App\Models\ProductUpdate;
use App\Models\Task;
use App\Models\User;
use App\Models\Webhook;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
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
    // Deprecated
    protected $dates = [
        'launched_at',
    ];
    protected $searchable = [
        'columns' => [
            'products.slug' => 10,
            'products.name' => 9,
        ],
    ];

    public function owner()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function members()
    {
        return $this->belongsToMany(User::class)->withTimestamps();
    }

    public function tasks()
    {
        return $this->hasMany(Task::class);
    }

    public function productUpdates()
    {
        return $this->hasMany(ProductUpdate::class);
    }

    public function webhooks()
    {
        return $this->hasMany(Webhook::class);
    }
}
