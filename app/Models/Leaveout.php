<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Leaveout extends Model
{
    protected $fillable = [
        'category',
        'comment',
        'from_date',
        'to_date',
        'student_id',
        'created_by',
        'updated_by',
    ];

    const CATEGORIES = [
        'casual',
        'sick',
    ];

    protected $casts = [
        'from_date' => 'datetime',
        'to_date' => 'datetime',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function($disciplinary) {
            $disciplinary->created_by = Auth::id();
        });

        static::updating(function($disciplinary) {
            $disciplinary->updated_by = Auth::id();
        });
    }

    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by', 'id');
    }

    public function updatedBy()
    {
        return $this->belongsTo(User::class, 'updated_by', 'id');
    }
}
