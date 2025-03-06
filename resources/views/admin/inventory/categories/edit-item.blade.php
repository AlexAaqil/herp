<x-authenticated-layout>
    <x-slot name="head">
        <title>Inventory Item | Update</title>
    </x-slot>

    <section class="Inventory">
        <div class="custom_form">
            <div class="header">
                <div class="icon">
                    <a href="{{ route('inventory-categories.index') }}">
                        <span class="fas fa-arrow-left"></span>
                    </a>
                </div>
                <p>Update Inventory Item</p>
            </div>

            <form action="{{ route('inventory-items.update', $inventory_item->id) }}" method="post">
                @csrf
                @method('patch')

                <div class="input_group_3">
                    <div class="inputs">
                        <label for="inventory_category_id">Inventory Category</label>
                        <select name="inventory_category_id" id="inventory_category_id">
                            <option value="">Select Category</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ old('inventory_category_id', $inventory_item->inventory_category_id) == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                        <x-input-error field="inventory_category_id" />
                    </div>
    
                    <div class="inputs">
                        <label for="item_name">Item Name</label>
                        <input type="text" name="item_name" id="item_name" value="{{ old('item_name', $inventory_item->name) }}">
                        <x-input-error field="item_name" />
                    </div>
    
                    <div class="inputs">
                        <label for="unit">Unit of measurement (Kgs, ltrs, pcs)</label>
                        <input type="text" name="unit" id="unit" value="{{ old('unit', $inventory_item->unit) }}">
                        <x-input-error field="unit" />
                    </div>
                </div>

                <div class="buttons">
                    <button type="submit">Update Item</button>

                    <button type="button" class="btn_danger" onclick="deleteItem({{ $inventory_item->id }}, 'inventory item');"
                        form="deleteForm_{{ $inventory_item->id }}">
                        <i class="fas fa-trash-alt delete"></i>
                        <span>Delete Item</span>                        
                    </button>
                </div>
            </form>

            <form id="deleteForm_{{ $inventory_item->id }}" action="{{ route('inventory-items.destroy', $inventory_item->id) }}" method="post"
                style="display: none;">
                @csrf
                @method('DELETE')
            </form>
        </div>
    </section>

    <x-slot name="scripts">
        <x-sweetalert />
    </x-slot>
</x-authenticated-layout>
