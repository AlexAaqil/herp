<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ExamRecord extends Model
{
    protected $fillable = [
        'marks',
        'grade',
        'classroom',
        'student_id',
        'exam_id',
        'subject_id',
    ];

    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    public function exam()
    {
        return $this->belongsTo(Exam::class);
    }

    public function subject()
    {
        return $this->belongsTo(Subject::class);
    }

    public static function determineGrade(int $marks): ?string
    {
        $grade = Grade::where('min_marks', '<=', $marks)
            ->where('max_marks', '>=', $marks)
            ->first();
        
        return $grade ? $grade->grade : null;
    }
}
