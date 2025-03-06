<?php

namespace App\Models\Payments;

use Illuminate\Database\Eloquent\Model;

class ExpenseCategory extends Model
{
    protected $fillable = [
        'name',
        'description',
    ];

    public $timestamps = false;

    public function expenses()
    {
        return $this->hasMany(Expense::class, 'expense_category_id');
    }
}
