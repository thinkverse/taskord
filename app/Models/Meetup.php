<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Multicaret\Acquaintances\Traits\CanBeSubscribed;
use Rennokki\QueryCache\Traits\QueryCacheable;

class Meetup extends Model
{
    use CanBeSubscribed;
    use QueryCacheable;
    use HasFactory;

    public $cacheFor = 3600;
    public $cacheTags = ['meetups'];
    public $cachePrefix = 'meetups_';
    
    protected static $flushCacheOnUpdate = true;
    
    protected $fillable = [
        'user_id',
        'name',
        'slug',
        'tagline',
        'description',
        'location',
        'cover',
        'date',
        'hidden',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
