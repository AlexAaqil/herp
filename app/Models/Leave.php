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
        'casual',
        'emergency',
        'maternal',
        'sick',
        'study',
    ];

    const RESPONSES = [
        'pending',
        'approved',
        'rejected',
    ];

    protected $casts = [
        'from_date' => 'datetime',
        'to_date' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
