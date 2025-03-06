<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InventoryItem extends Model
{
    protected $fillable = [
        'name',
        'unit',
        'inventory_category_id',
    ];

    public $timestamps = false;

    public function category()
    {
        return $this->belongsTo(InventoryCategory::class);
    }

    public function records()
    {
        return $this->hasMany(InventoryRecord::class);
    }
}
