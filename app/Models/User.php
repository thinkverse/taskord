<?php

namespace App\Models;

use App\Jobs\VerifyEmailQueue;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Multicaret\Acquaintances\Traits\CanBeFollowed;
use Multicaret\Acquaintances\Traits\CanFollow;
use Multicaret\Acquaintances\Traits\CanLike;
use Multicaret\Acquaintances\Traits\CanSubscribe;
use Nicolaslopezj\Searchable\SearchableTrait;
use QCod\Gamify\Gamify;
use Rennokki\QueryCache\Traits\QueryCacheable;

class User extends Authenticatable implements MustVerifyEmail
{
    use CanLike;
    use Notifiable;
    use Gamify;
    use CanFollow, CanBeFollowed, CanSubscribe;
    use QueryCacheable;
    use HasFactory;
    use SearchableTrait;

    public $cacheFor = 3600;
    public $cacheTags = ['users'];
    public $cachePrefix = 'users_';

    protected static $flushCacheOnUpdate = true;

    protected $fillable = [
        'username',
        'firstname',
        'avatar',
        'email',
        'password',
        'provider',
        'provider_id',
        'last_ip',
        'email_verified_at',
        'api_token',
    ];
    protected $searchable = [
        'columns' => [
            'users.username' => 10,
            'users.firstname' => 9,
        ],
    ];
    protected $hidden = [
        'password', 'remember_token',
    ];
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * @return BelongsTo
     */
    public function tasks(): HasMany
    {
        return $this->hasMany(Task::class);
    }

    /**
     * @return BelongsTo
     */
    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class);
    }

    /**
     * @return BelongsTo
     */
    public function commentReplies(): HasMany
    {
        return $this->hasMany(CommentReply::class);
    }

    /**
     * @return BelongsTo
     */
    public function milestones(): HasMany
    {
        return $this->hasMany(Milestone::class);
    }

    /**
     * @return BelongsTo
     */
    public function ownedProducts(): HasMany
    {
        return $this->hasMany(Product::class);
    }

    /**
     * @return BelongsTo
     */
    public function products(): BelongsToMany
    {
        return $this->belongsToMany(Product::class);
    }

    /**
     * @return BelongsTo
     */
    public function productUpdates(): BelongsTo
    {
        return $this->belongsTo(ProductUpdate::class);
    }

    /**
     * @return BelongsTo
     */
    public function questions(): HasMany
    {
        return $this->hasMany(Question::class);
    }

    /**
     * @return BelongsTo
     */
    public function answers(): HasMany
    {
        return $this->hasMany(Answer::class);
    }

    /**
     * @return BelongsTo
     */
    public function patron(): HasOne
    {
        return $this->hasOne(Patron::class);
    }

    /**
     * @return BelongsTo
     */
    public function webhooks(): HasMany
    {
        return $this->hasMany(Webhook::class);
    }

    /**
     * @return BelongsTo
     */
    public function meetups(): HasMany
    {
        return $this->hasMany(Meetup::class);
    }

    /**
     * @return BelongsTo
     */
    public function sendEmailVerificationNotification()
    {
        VerifyEmailQueue::dispatch($this);
    }
}
