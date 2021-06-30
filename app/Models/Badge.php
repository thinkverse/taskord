<?php

namespace App\Models;

use Rennokki\QueryCache\Traits\QueryCacheable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Badge extends Model
{
    use HasFactory;
    use QueryCacheable;
}
