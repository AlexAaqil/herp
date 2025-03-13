<x-authenticated-layout>
    <x-slot name="head">
        <title>Expenses</title>
    </x-slot>

    <section class="Expenses">
        <div class="system_nav">
            <a href="{{ route('expense-categories.index') }}">Categories</a>
            <a href="{{ route('expense-recipients.index') }}">Recipients</a>
            <span>Expenses</span>
        </div>

        <div class="body">
            @if ($expenses->isNotEmpty())
                <div class="table list_items">
                    <div class="header">
                        <div class="details">
                            <p class="title">Expenses</p>
                            <p class="stats">
                                <span>{{ $count_expenses }} {{ Str::plural('Expense', $count_expenses) }}</span>
                            </p>
                        </div>
    
                        <x-search-input />

                        <div class="btn">
                            <a href="{{ route('expenses.create') }}">New Expense</a>
                        </div>
                    </div>
    
                    <table>
                        <thead>
                            <tr>
                                <th class="center">#</th>
                                <th>Recipient</th>
                                <th>Category</th>
                                <th>Amount</th>
                                <th>Date</th>
                                <th class="actions center">Actions</th>
                            </tr>
                        </thead>
            
                        <tbody>
                            @foreach ($expenses as $expense)
                                <tr class="searchable">
                                    <td class="center">{{ $loop->iteration }}</td>
                                    <td>{{ $expense->recipient->name }}</td>
                                    <td>{{ $expense->category->name }}</td>
                                    <td>{{ number_format($expense->amount_paid, 2) }}</td>
                                    <td>{{ $expense->date->format('d-m-Y') }}</td>
                                    <td class="actions center">
                                        <div class="action_buttons">
                                            <div class="action">
                                                <a href="{{ route('expenses.edit', $expense->id) }}">
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
                <p>No Expenses yet.</p>
                <a href="{{ route('expenses.create') }}">Add New</a>
            @endif
        </div>
    </section>

    <x-slot name="scripts">
        <x-search />
    </x-slot>
</x-authenticated-layout>
