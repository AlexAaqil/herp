<?php

namespace App\Models\Payments;

use Illuminate\Database\Eloquent\Model;

class ExpenseRecipient extends Model
{
    protected $fillable = [
        'name',
        'email',
        'phone_number',
        'company_name',
    ];

    public function expenses()
    {
        return $this->hasMany(Expense::class, 'expense_recipient_id');
    }
}
