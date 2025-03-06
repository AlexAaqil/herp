<?php

namespace App\Http\Controllers\Inventory;

use App\Http\Controllers\Controller;
use App\Models\Inventory\InventoryRecord;
use App\Models\Inventory\InventoryItem;
use Illuminate\Http\Request;

class InventoryRecordController extends Controller
{
    public function index()
    {
        $inventory_records = InventoryRecord::with('item')->orderBy('date')->get();
        $count_inventory_records = $inventory_records->count();

        return view('admin.inventory.records.index', compact('inventory_records', 'count_inventory_records'));
    }

    public function create()
    {
        $items = InventoryItem::orderBy('name')->get();

        return view('admin.inventory.records.create', compact('items'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'type' => 'required|in:0,1',
            'quantity' => 'required|numeric',
            'remaining' => 'nullable|numeric',
            'description' => 'nullable|string|max:255',
            'date' => 'required|date',
            'inventory_item_id' => 'required|exists:inventory_items,id',
        ], [
            'inventory_item_id.required' => 'You have to select an item.',
            'quantity.required' => 'You have to enter a quantity.',
            'date.required' => 'You have to enter a date.',
        ]);

        InventoryRecord::create($validated);

        return redirect()->route('inventory-records.index')->with('success', 'Inventory has been added.');
    }

    public function edit(InventoryRecord $inventory_record)
    {
        $items = InventoryItem::orderBy('name')->get();

        return view('admin.inventory.records.edit', compact('items', 'inventory_record'));
    }

    public function update(Request $request, InventoryRecord $inventory_record)
    {
        $validated = $request->validate([
            'type' => 'required|in:0,1',
            'quantity' => 'required|numeric',
            'remaining' => 'nullable|numeric',
            'description' => 'nullable|string|max:255',
            'date' => 'required|date',
            'inventory_item_id' => 'required|exists:inventory_items,id',
        ], [
            'inventory_item_id.required' => 'You have to select an item.',
            'quantity.required' => 'You have to enter a quantity.',
            'date.required' => 'You have to enter a date.',
        ]);

        $inventory_record->update($validated);

        return redirect()->route('inventory-records.index')->with('success', 'Inventory has been updated.');
    }

    public function destroy(InventoryRecord $inventory_record)
    {
        $inventory_record->delete();

        return redirect()->route('inventory-records.index')->with('success', 'Inventory has been deleted.');
    }
}
