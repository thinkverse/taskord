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
            if (Auth::user()->staffShip) {
                return $feature->staff ? true : false;
            } else if (Auth::user()->isBeta) {
                return $feature->beta ? true : false;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }
}
