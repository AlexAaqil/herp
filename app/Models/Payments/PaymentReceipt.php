<?php

namespace App\Models\Payments;

use Illuminate\Database\Eloquent\Model;

class PaymentReceipt extends Model
{
    protected $fillable = [
        'amount_paid',
        'balance',
        'date_paid',
        'payment_record_id',
    ];

    public function paymentRecord()
    {
        return $this->belongsTo(PaymentRecord::class);
    }
}
