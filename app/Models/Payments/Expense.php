<?php

namespace App\Models\Payments;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class Expense extends Model
{
    protected $fillable = [
        'amount_paid',
        'payment_method',
        'reference_number',
        'payment_status',
        'description',
        'date',
        'expense_category_id',
        'expense_recipient_id',
        'created_by',
        'updated_by',
    ];

    protected $casts = [
        'date' => 'datetime',
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

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by', 'id');
    }

    public function updatedBy()
    {
        return $this->belongsTo(User::class, 'updated_by', 'id');
    }

    public function category()
    {
        return $this->belongsTo(ExpenseCategory::class, 'expense_category_id');
    }

    public function recipient()
    {
        return $this->belongsTo(ExpenseRecipient::class, 'expense_recipient_id');
    }
}
