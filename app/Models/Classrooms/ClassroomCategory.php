<?php

namespace App\Models\Classrooms;

use Illuminate\Database\Eloquent\Model;

class ClassroomCategory extends Model
{
    protected $fillable = ['name'];

    public $timestamps = false;

    public function classes()
    {
        return $this->hasMany(Classroom::class);
    }
}
