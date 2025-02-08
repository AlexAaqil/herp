<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Guardian extends Model
{
    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'phone_number',
        'phone_other',
        'address',
        'password',
    ];

    public function getFullNameAttribute()
    {
        return $this->first_name ." ". $this->last_name;
    }

    public function getPhoneNumbersAttribute(): string
    {
        $numbers = array_filter(
            [$this->phone_number, $this->phone_other],
            fn($value) => !is_null($value) && $value !== ''
        );

        return implode(' / ', $numbers);
    }

    public function students()
    {
        return $this->belongsToMany(Student::class);
    }
}
