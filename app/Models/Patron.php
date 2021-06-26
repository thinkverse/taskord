<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Patron extends Model
{
    protected $fillable = [
        'user_id',
        'checkout_id',
        'subscription_plan_id',
        'cancel_url',
        'update_url',
        'event_time',
        'next_bill_date',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
