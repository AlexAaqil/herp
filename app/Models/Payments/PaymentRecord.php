<?php

namespace App\Models\Payments;

use Illuminate\Database\Eloquent\Model;
use App\Models\Student;

class PaymentRecord extends Model
{
    protected $fillable = [
        'reference_number',
        'payment_method',
        'amount_paid',
        'balance',
        'payment_id',
        'student_id',
    ];

    public function paymentReceipts()
    {
        return $this->hasMany(PaymentReceipt::class);
    }

    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    public function payment()
    {
        return $this->belongsTo(Payment::class);
    }
}
