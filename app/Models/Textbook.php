<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Textbook extends Model
{
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($textbook) {
            $textbook->issued_by = Auth::id();
        });

        static::updating(function ($textbook) {
            $textbook->received_by = Auth::id();
        });
    }

    const STATUSES = [
        'issued',
        'returned',
        'lost',
    ];

    protected $fillable = [
        'book_name',
        'book_number',
        'status',
        'date_issued',
        'date_returned',
        'student_id',
        'issued_by',
        'received_by',
    ];

    public function student()
    {
        return $this->belongsTo(Student::class, 'student_id', 'id');
    }

    public function issuedBy()
    {
        return $this->belongsTo(User::class, 'issued_by', 'id');
    }

    public function receivedBy()
    {
        return $this->belongsTo(User::class, 'received_by', 'id');
    }
}
