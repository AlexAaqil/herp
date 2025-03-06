<?php

namespace App\Http\Controllers\Inventory;

use App\Http\Controllers\Controller;
use App\Models\Inventory\InventoryItem;
use App\Models\Inventory\InventoryCategory;
use Illuminate\Http\Request;

class InventoryItemController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'item_name' => 'required|string|max:180|unique:inventory_items,name',
            'unit' => 'required|string',
            'inventory_category_id' => 'nullable|exists:inventory_categories,id',
        ]);

        InventoryItem::create([
            'name' => $validated['item_name'],
            'unit' => $validated['unit'],
            'inventory_category_id' => $validated['inventory_category_id'],
        ]);

        return redirect()->route('inventory-categories.index')->with('success', 'Item has been added.');
    }

    public function edit(InventoryItem $inventory_item)
    {
        $categories = InventoryCategory::orderBy('name')->get();

        return view('admin.inventory.categories.edit-item', compact('categories', 'inventory_item'));
    }

    public function update(Request $request, InventoryItem $inventory_item)
    {
        $validated = $request->validate([
            'item_name' => 'required|string|max:180|unique:inventory_items,name,'.$inventory_item->id,
            'unit' => 'required|string',
            'inventory_category_id' => 'nullable|exists:inventory_categories,id',
        ]);

        $inventory_item->update([
            'name' => $validated['item_name'],
            'unit' => $validated['unit'],
            'inventory_category_id' => $validated['inventory_category_id'],
        ]);

        return redirect()->route('inventory-categories.index')->with('success', 'Item has been updated.');
    }

    public function destroy(InventoryItem $inventory_item)
    {
        $inventory_item->delete();

        return redirect()->route('inventory-categories.index')->with('success', 'Item has been deleted.');
    }
}
