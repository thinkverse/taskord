<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Multicaret\Acquaintances\Traits\CanBeLiked;
use Nicolaslopezj\Searchable\SearchableTrait;
use Rennokki\QueryCache\Traits\QueryCacheable;

class Answer extends Model
{
    use CanBeLiked;
    use HasFactory;
    use QueryCacheable;
    use SearchableTrait;

    public $cacheFor = 3600;
    public $cacheTags = ['answers'];
    public $cachePrefix = 'answers_';
    protected static $flushCacheOnUpdate = true;
    protected $fillable = [
        'user_id',
        'question_id',
        'answer',
        'hidden',
    ];

    protected $searchable = [
        'columns' => [
            'answers.answer' => 10,
        ],
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
