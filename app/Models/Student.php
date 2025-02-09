<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Classrooms\Classroom;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Vite;

class Student extends Model
{
    protected $guarded = [];

    public function getFullNameAttribute()
    {
        return $this->first_name ." ". $this->last_name;
    }

    public function getImagePathAttribute()
    {
        if($this->image && Storage::disk('public')->exists($this->image)) {
            return asset('/storage/'.$this->image);
        }

        return Vite::asset('resources/images/default_profile.jpg');
    }

    public function classroom()
    {
        return $this->belongsTo(Classroom::class);
    }

    public function dorm()
    {
        return $this->belongsTo(Dorm::class);
    }

    public function guardians()
    {
        return $this->belongsToMany(Guardian::class);
    }

    public function disciplinaries()
    {
        return $this->hasMany(Disciplinary::class);
    }
}
