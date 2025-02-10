<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Leave extends Model
{
    protected $fillable = [
        'category',
        'comment',
        'from_date',
        'to_date',
        'status',
        'response',
        'user_id',
    ];

    const CATEGORIES = [
        'emergency',
        'maternal',
        'sick',
        'study',
    ];
}
