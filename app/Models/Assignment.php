<?php

namespace App\Models;

use App\Models\Classrooms\Classroom;
use Illuminate\Database\Eloquent\Model;

class Assignment extends Model
{
    protected $fillable = [
        'date_issued', 
        'deadline', 
        'description', 
        'uploaded_file',
        'teacher_id', 
        'classroom_id', 
        'subject_id', 
    ];

    protected $casts = [
        'date_issued' => 'datetime',
        'deadline' => 'datetime',
    ];

    public function teacher()
    {
        return $this->belongsTo(User::class, 'teacher_id');
    }

    public function classroom()
    {
        return $this->belongsTo(Classroom::class);
    }

    public function subject()
    {
        return $this->belongsTo(Subject::class);
    }
}
