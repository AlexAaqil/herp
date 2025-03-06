<x-authenticated-layout>
    <x-slot name="head">
        <title>Expense Category | Update</title>
    </x-slot>

    <section class="Expenses">
        <div class="custom_form">
            <div class="header">
                <div class="icon">
                    <a href="{{ route('expense-categories.index') }}">
                        <span class="fas fa-arrow-left"></span>
                    </a>
                </div>
                <p>Update Expense Category</p>
            </div>

            <form action="{{ route('expense-categories.update', $expense_category->id) }}" method="post">
                @csrf
                @method('patch')

                <div class="input_group">
                    <div class="inputs">
                        <label for="name" class="required">Category Name</label>
                        <input type="text" name="name" id="name" placeholder="Labor, Electricity Bill" value="{{ old('name', $expense_category->name) }}">
                        <x-input-error field="name" />
                    </div>
    
                    <div class="inputs">
                        <label for="description">Description</label>
                        <input type="text" name="description" id="description" placeholder="Daily Labor, KPLC Bills" value="{{ old('description', $expense_category->description) }}">
                        <x-input-error field="description" />
                    </div>
                </div>

                <div class="buttons">
                    <button type="submit">Update Expense Category</button>

                    <button type="button" class="btn_danger" onclick="deleteItem({{ $expense_category->id }}, 'expense category');"
                        form="deleteForm_{{ $expense_category->id }}">
                        <i class="fas fa-trash-alt delete"></i>
                        <span>Delete Expense Category</span>                        
                    </button>
                </div>
            </form>

            <form id="deleteForm_{{ $expense_category->id }}" action="{{ route('expense-categories.destroy', $expense_category->id) }}" method="post"
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
