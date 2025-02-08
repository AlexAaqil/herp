<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Classrooms\Classroom;

class TeacherSubjectClassroom extends Model
{
    protected $table = 'teacher_subject_classroom';

    protected $fillable = [
        'classroom_id',
        'subject_id',
        'teacher_id',
    ];

    public function classroom()
    {
        return $this->belongsTo(Classroom::class);
    }

    public function subject()
    {
        return $this->belongsTo(Subject::class);
    }

    public function teacher()
    {
        return $this->belongsTo(User::class);
    }
}
