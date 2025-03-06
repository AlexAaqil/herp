<x-authenticated-layout>
    <x-slot name="head">
        <title>Expense Categories</title>
    </x-slot>

    <section class="Expenses">
        <div class="system_nav">
            <a href="{{ route('expenses.index') }}">Expenses</a>
            <a href="{{ route('expense-recipients.index') }}">Suppliers</a>
            <span>Categories</span>
        </div>

        <div class="body row_container">
            <div class="column">
                @if ($expense_categories->isNotEmpty())
                <div class="table list_items">
                    <div class="header">
                        <div class="details">
                            <p class="title">Expense Categories</p>
                            <p class="stats">
                                <span>{{ $count_expense_categories }} {{ Str::plural('Category', $count_expense_categories) }}</span>
                            </p>
                        </div>
    
                        <x-search-input />
                    </div>
    
                    <table>
                        <thead>
                            <tr>
                                <th class="center">#</th>
                                <th>Name</th>
                                <th>Description</th>
                                <th class="actions center">Actions</th>
                            </tr>
                        </thead>
            
                        <tbody>
                            @foreach ($expense_categories as $category)
                                <tr class="searchable">
                                    <td class="center">{{ $loop->iteration }}</td>
                                    <td>{{ $category->name }}</td>
                                    <td>{{ $category->description ?? '-' }}</td>
                                    <td class="actions center">
                                        <div class="action_buttons">
                                            <div class="action">
                                                <a href="{{ route('expense-categories.edit', $category->id) }}">
                                                    <span class="fas fa-eye"></span> 
                                                </a> 
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @else
                    <p>No expense categires yet.</p>
                @endif
            </div>

            <div class="column">
                <div class="custom_form">
                    <div class="header">
                        <p>New Category</p>
                    </div>

                    <form action="{{ route('expense-categories.store') }}" method="post">
                        @csrf

                        <div class="inputs">
                            <label for="name" class="required">Category Name</label>
                            <input type="text" name="name" id="name" placeholder="Labor, Electricity Bill" value="{{ old('name') }}">
                            <x-input-error field="name" />
                        </div>

                        <div class="inputs">
                            <label for="description">Description</label>
                            <input type="text" name="description" id="description" placeholder="Daily Labor, KPLC Bills" value="{{ old('description') }}">
                            <x-input-error field="description" />
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
