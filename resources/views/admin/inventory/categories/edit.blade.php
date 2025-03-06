<x-authenticated-layout>
    <x-slot name="head">
        <title>Inventory Category | Update</title>
    </x-slot>

    <section class="Inventory">
        <div class="custom_form">
            <div class="header">
                <div class="icon">
                    <a href="{{ route('inventory-categories.index') }}">
                        <span class="fas fa-arrow-left"></span>
                    </a>
                </div>
                <p>Update Inventory Category</p>
            </div>

            <form action="{{ route('inventory-categories.update', $inventory_category->id) }}" method="post">
                @csrf
                @method('patch')

                <div class="inputs">
                    <label for="name">Inventory Category</label>
                    <input type="text" name="name" id="name" value="{{ old('name', $inventory_category->name) }}">
                </div>

                <div class="buttons">
                    <button type="submit">Update Category</button>

                    <button type="button" class="btn_danger" onclick="deleteItem({{ $inventory_category->id }}, 'inventory category and its items');"
                        form="deleteForm_{{ $inventory_category->id }}">
                        <i class="fas fa-trash-alt delete"></i>
                        <span>Delete Category</span>                        
                    </button>
                </div>
            </form>

            <form id="deleteForm_{{ $inventory_category->id }}" action="{{ route('inventory-categories.destroy', $inventory_category->id) }}" method="post"
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
