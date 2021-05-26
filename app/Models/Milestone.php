<?php

namespace App\Models;

use App\Models\User;
use App\Models\Task;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Multicaret\Acquaintances\Traits\CanBeLiked;
use Rennokki\QueryCache\Traits\QueryCacheable;

class Milestone extends Model
{
    use CanBeLiked;
    use HasFactory;
    use QueryCacheable;

    public $cacheFor = 3600;
    public $cacheTags = ['milestones'];
    public $cachePrefix = 'milestones_';

    protected static $flushCacheOnUpdate = true;

    protected $fillable = [
        'user_id',
        'name',
        'description',
        'start_date',
        'end_date',
        'hidden',
    ];
    protected $dates = [
        'start_date',
        'end_date',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function tasks()
    {
        return $this->hasMany(Task::class);
    }
}
