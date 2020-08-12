<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Overtrue\LaravelLike\Traits\Likeable;
use Rennokki\QueryCache\Traits\QueryCacheable;

class Answer extends Model
{
    use QueryCacheable, Likeable;

    protected $cacheFor = 3600;

    protected $fillable = [
        'user_id',
        'question_id',
        'answer',
    ];

    public function user()
    {
        return $this->belongsTo(\App\Models\User::class);
    }

    public function question()
    {
        return $this->belongsTo(\App\Models\Question::class);
    }
}
