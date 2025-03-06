<?php

namespace App\Http\Controllers;

use App\Models\InventoryCategory;
use App\Models\InventoryItem;
use Illuminate\Http\Request;

class InventoryCategoryController extends Controller
{
    public function index()
    {
        $categorized_items = InventoryCategory::with(['items' => function ($query) {
                $query->orderBy('name');
            }])
            ->orderBy('name')
            ->get();
    
        $uncategorized_items = InventoryItem::whereNull('inventory_category_id')
            ->orderBy('name')
            ->get();
    
        $count_categories = InventoryCategory::count();
        $count_items = InventoryItem::count();
    
        return view('admin.inventory.categories.index', compact(
            'categorized_items', 
            'uncategorized_items', 
            'count_categories', 
            'count_items'
        ));
    }

    public function store(Request $request)
    {
        $request->validate([
            'category_name' => 'required|string|max:180|unique:inventory_categories,name',
        ]);

        InventoryCategory::create([
            'name' => $request->category_name
        ]);

        return redirect()->route('inventory-categories.index')->with('success', 'Category has been added.');
    }

    public function edit(InventoryCategory $inventory_category)
    {
        return view('admin.inventory.categories.edit', compact('inventory_category'));
    }

    public function update(Request $request, InventoryCategory $inventory_category)
    {
        $request->validate([
            'category_name' => 'required|string|max:180|unique:inventory_categories,name,'.$inventory_category->id,
        ]);

        $inventory_category->update([
            'name' => $request->category_name
        ]);

        return redirect()->route('inventory-categories.index')->with('success', 'Category has been updated.');
    }

    public function destroy(InventoryCategory $inventory_category)
    {
        $inventory_category->delete();

        return redirect()->route('inventory-categories.index')->with('success', 'Category and its items have been deleted.');
    }
}
