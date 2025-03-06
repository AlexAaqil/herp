<x-authenticated-layout>
    <x-slot name="head">
        <title>Inventory Categories</title>
    </x-slot>

    <section class="Inventory">
        <div class="system_nav">
            <a href="{{ route('inventory-records.index') }}">Inventory Records</a>
            <span>Categories</span>
        </div>

        <div class="body row_container">
            <div class="column table">
                <div class="header">
                    <div class="details">
                        <p class="title">Inventory Categories</p>
                        <p class="stats">
                            <span>{{ $count_categories }} {{ Str::plural('Category', $count_categories) }}</span>
                            <span>{{ $count_items }} {{ Str::plural('Item', $count_items) }}</span>
                        </p>
                    </div>

                    <x-search-input />
                </div>

                @if($categorized_items->isNotEmpty())
                    <ol>
                        @foreach ($categorized_items as $category)
                            <li class="searchable">
                                <a href="{{ route('inventory-categories.edit', $category->id) }}">
                                    {{ $category->name }}
                                </a>
                                <ul>
                                    @forelse ($category->items as $item)
                                        <li>
                                            <a href="{{ route('inventory-items.edit', $item->id) }}">
                                                {{ $item->name }} ({{ $item->unit }})
                                            </a>
                                        </li>
                                    @empty
                                        <li><span>No items available.</span></li>
                                    @endforelse
                                </ul>
                            </li>
                        @endforeach
                    </ol>
                @else
                    <p>No Categories have been added yet.</p>
                @endif

                @if($uncategorized_items->isNotEmpty())
                    <p class="title">Uncategorized Items</p>
                    <ol class="nested_list">
                        @foreach ($uncategorized_items as $item)
                            <li class="searchable">
                                <a href="{{ route('inventory-items.edit', $item->id) }}">
                                    {{ $item->name }} ({{ $item->unit }})
                                </a>
                            </li>
                        @endforeach
                    </ol>
                @endif
            </div>

            <div class="column forms">
                <div class="custom_form">
                    <div class="header">
                        <p>New Category</p>
                    </div>
        
                    <form action="{{ route('inventory-categories.store') }}" method="post">
                        @csrf
        
                        <div class="inputs">
                            <label for="category_name">Category</label>
                            <input type="text" name="category_name" id="category_name" value="{{ old('category_name') }}">
                            <x-input-error field="category_name" />
                        </div>
        
                        <button type="submit">Save</button>
                    </form>
                </div>
        
                <div class="custom_form">
                    <div class="header">
                        <p>New Item</p>
                    </div>
        
                    <form action="{{ route('inventory-items.store') }}" method="post">
                        @csrf
        
                        <div class="inputs">
                            <label for="inventory_category_id">Inventory Category</label>
                            <select name="inventory_category_id" id="inventory_category_id">
                                <option value="">Select Category</option>
                                @foreach($categorized_items as $category)
                                    <option value="{{ $category->id }}" {{ old('inventory_category_id') == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                            <x-input-error field="inventory_category_id" />
                        </div>
        
                        <div class="inputs">
                            <label for="item_name">Item Name</label>
                            <input type="text" name="item_name" id="item_name" value="{{ old('item_name') }}">
                            <x-input-error field="item_name" />
                        </div>
        
                        <div class="inputs">
                            <label for="unit">Unit of measurement (Kgs, ltrs, pcs)</label>
                            <input type="text" name="unit" id="unit" value="{{ old('unit') }}">
                            <x-input-error field="unit" />
                        </div>
        
                        <button type="submit">Save</button>
                    </form>
                </div>
            </div>
        </div>
    </section>

    <x-slot name="scripts">
        <x-search />
    </x-slot>
</x-authenticated-layout>
