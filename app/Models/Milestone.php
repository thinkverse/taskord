<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Rennokki\QueryCache\Traits\QueryCacheable;

class Milestone extends Model
{
    use HasFactory;
    use QueryCacheable;

    public $cacheFor = 3600;
    public $cacheTags = ['products'];
    public $cachePrefix = 'products_';
    protected static $flushCacheOnUpdate = true;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'start_date',
        'end_date',
    ];

    protected $dates = [
        'start_date',
        'end_date',
    ];

    public function user()
    {
        return $this->belongsTo(\App\Models\User::class, 'user_id');
    }

    public function tasks()
    {
        return $this->hasMany(\App\Models\Task::class);
    }
}
