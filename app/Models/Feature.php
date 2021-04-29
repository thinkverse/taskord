<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Rennokki\QueryCache\Traits\QueryCacheable;
use Illuminate\Support\Facades\Auth;

class Feature extends Model
{
    use HasFactory;
    use QueryCacheable;

    protected $fillable = [
        'name',
        'description',
        'slug',
    ];

    public static function enabled($slug)
    {
        if (Auth::check()) {
            $feature = self::where('slug', $slug)->first();
            return $feature->enabled ? true : false;
        } else {
            return false;
        }
    }
}
