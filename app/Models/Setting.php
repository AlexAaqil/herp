<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Setting extends Model
{
    protected $fillable = [
        'school_name',
        'school_acronym',
        'school_address',
        'school_phone_number',
        'school_phone_other',
        'school_email',
        'current_year',
        'current_term',
        'term_begins',
        'term_ends',
        'bursar_stamp',
        'principal_stamp',
        'storekeeper_stamp',
    ];

    protected $casts = [
        'term_begins' => 'datetime',
        'term_ends' => 'datetime',
    ];

    public function getPrincipalStampAttribute()
    {
        return array_key_exists('principal_stamp', $this->attributes) && $this->attributes['principal_stamp']
            ? asset('storage/' . $this->attributes['principal_stamp'])
            : asset('assets/images/default_image.jpg');
    }

    public function getBursarStampAttribute()
    {
        return array_key_exists('bursar_stamp', $this->attributes) && $this->attributes['bursar_stamp']
            ? asset('storage/' . $this->attributes['bursar_stamp'])
            : asset('assets/images/default_image.jpg');
    }

    public function getStorekeeperStampAttribute()
    {
        return array_key_exists('storekeeper_stamp', $this->attributes) && $this->attributes['storekeeper_stamp']
            ? asset('storage/' . $this->attributes['storekeeper_stamp'])
            : asset('assets/images/default_image.jpg');
    }
}
