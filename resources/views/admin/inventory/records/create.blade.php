<x-authenticated-layout>
    <x-slot name="head">
        <title>Inventory Record | New</title>
    </x-slot>

    <section class="Inventory">
        <div class="custom_form">
            <div class="header">
                <div class="icon">
                    <a href="{{ route('inventory-records.index') }}">
                        <span class="fas fa-arrow-left"></span>
                    </a>
                </div>
                <p>New Inventory</p>
            </div>

            <form action="{{ route('inventory-records.store') }}" method="post">
                @csrf

                <div class="input_group_3">
                    <div class="inputs">
                        <label for="type" class="required">Transaction</label>
                        <div class="custom_radio_buttons">
                            @foreach(App\Models\Inventory\InventoryRecord::TYPES as $key => $label)
                                <label>
                                    <input class="option_radio" 
                                        type="radio" 
                                        name="type" 
                                        value="{{ $key }}"
                                        {{ old('type', 0) == $key ? 'checked' : '' }}>
                                    <span>{{ ucfirst($label) }}</span>
                                </label>
                            @endforeach
                        </div>
                        <x-input-error field="type" />
                    </div>
    
                    <div class="inputs">
                        <label for="inventory_item_id" class="required">Item</label>
                        <select name="inventory_item_id" id="inventory_item_id">
                            <option value="">Select Item</option>
                            @foreach($items as $item)
                                <option value="{{ $item->id }}" {{ old('inventory_item_id') == $item->id ? "selected" : "" }}>{{ $item->name }}</option>
                            @endforeach
                        </select>
                        <x-input-error field="inventory_item_id" />
                    </div>
    
                    <div class="inputs">
                        <label for="quantity" class="required">Quantity</label>
                        <input type="number" name="quantity" id="quantity" value="{{ old('quantity') }}">
                        <x-input-error field="quantity" />
                    </div>
                </div>

                <div class="input_group_3">
                    <div class="inputs">
                        <label for="date" class="required">Date</label>
                        <input type="date" name="date" id="date" value="{{ old('date') }}">
                        <x-input-error field="date" />
                    </div>
    
                    <div class="inputs">
                        <label for="remaining">Remaining Amount</label>
                        <input type="number" name="remaining" id="remaining" value="{{ old('remaining') }}">
                        <x-input-error field="remaining" />
                    </div>
    
                    <div class="inputs">
                        <label for="description">Description</label>
                        <input type="text" name="description" id="description" value="{{ old('description') }}">
                        <x-input-error field="description" />
                    </div>
                </div>

                <button type="submit">Add Inventory</button>
            </form>
        </div>
    </section>
</x-authenticated-layout>
