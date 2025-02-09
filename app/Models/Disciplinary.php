<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Auth;

class Disciplinary extends Model
{
    protected $fillable = [
        'category',
        'comment',
        'student_id',
        'created_by',
        'updated_by',
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
