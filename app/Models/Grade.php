<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Grade extends Model
{
    protected $fillable = [
        'grade',
        'min_marks',
        'max_marks',
    ];

    public $timestamps = false;
}
