<?php

namespace App\Models\Inventory;

use Illuminate\Database\Eloquent\Model;

class InventoryRecord extends Model
{
    protected $fillable = [
        'type',
        'quantity',
        'remaining',
        'description',
        'date',
        'inventory_item_id',
    ];

    protected $casts = [
        'date' => 'datetime',
    ];

    const TYPES = [
        0 => 'Arrival',
        1 => 'Usage',
    ];

    public function getTransactionAttribute()
    {
        return $this->type == 0 ? 'Arrival' : 'Usage';
    }

    public function item()
    {
        return $this->belongsTo(InventoryItem::class, 'inventory_item_id');
    }
}
