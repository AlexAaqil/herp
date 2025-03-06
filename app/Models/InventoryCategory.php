<?php

namespace App\Models;

use App\Http\Controllers\InventoryItemController;
use Illuminate\Database\Eloquent\Model;

class InventoryCategory extends Model
{
    protected $fillable = [
        'name'
    ];

    public $timestamps = false;

    public function items()
    {
        return $this->hasMany(InventoryItem::class);
    }
}
