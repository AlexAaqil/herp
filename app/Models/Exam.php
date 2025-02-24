<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Exam extends Model
{
    protected $fillable = [
        'name',
        'year',
        'term',
    ];

    public function examRecords()
    {
        return $this->hasMany(ExamRecord::class);
    }
}
