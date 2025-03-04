<?php

namespace App\Models\Payments;

use Illuminate\Database\Eloquent\Model;
use App\Models\Classrooms\ClassroomCategory;

class Payment extends Model
{
    protected $fillable = [
        'name',
        'amount',
        'year',
        'term',
        'classroom_category_id',
    ];

    public function classroomCategory()
    {
        return $this->belongsTo(ClassroomCategory::class);
    }

    public function paymentRecords()
    {
        return $this->hasMany(PaymentRecord::class);
    }
}
