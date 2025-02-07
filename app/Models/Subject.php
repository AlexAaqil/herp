<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Subject extends Model
{
    protected $fillable = [
        'name',
        'acronym',
        'code',
    ];

    public $timestamps = false;
}
