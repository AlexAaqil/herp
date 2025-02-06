<?php

namespace App\Models\Classrooms;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Classroom extends Model
{
    protected $fillable = [
        'name',
        'classroom_category_id',
        'class_teacher_id',
    ];
    
    public $timestamps = false;

    public function classroomCategory()
    {
        return $this->belongsTo(ClassroomCategory::class);
    }

    public function classTeacher()
    {
        return $this->belongsTo(User::class, 'class_teacher_id');
    }
}
