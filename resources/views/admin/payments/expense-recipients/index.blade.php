<x-authenticated-layout>
    <x-slot name="head">
        <title>Suppliers</title>
    </x-slot>

    <section class="Expenses">
        <div class="system_nav">
            <a href="{{ route('expenses.index') }}">Expenses</a>
            <a href="{{ route('expense-categories.index') }}">Categories</a>
            <span>Suppliers</span>
        </div>

        <div class="body row_container">
            <div class="column">
                @if ($recipients->isNotEmpty())
                    <div class="table list_items">
                        <div class="header">
                            <div class="details">
                                <p class="title">Suppliers</p>
                                <p class="stats">
                                    <span>{{ $count_recipients }} {{ Str::plural('Supplier', $count_recipients) }}</span>
                                </p>
                            </div>
        
                            <x-search-input />
                        </div>
        
                        <table>
                            <thead>
                                <tr>
                                    <th class="center">#</th>
                                    <th>Name</th>
                                    <th>Phone Number</th>
                                    <th>Email Address</th>
                                    <th>Company Name</th>
                                    <th class="actions center">Actions</th>
                                </tr>
                            </thead>
                
                            <tbody>
                                @foreach ($recipients as $recipient)
                                    <tr class="searchable">
                                        <td class="center">{{ $loop->iteration }}</td>
                                        <td>{{ $recipient->name }}</td>
                                        <td>{{ $recipient->phone_number }}</td>
                                        <td>{{ $recipient->email ?? '-' }}</td>
                                        <td>{{ $recipient->company_name ?? '-' }}</td>
                                        <td class="actions center">
                                            <div class="action_buttons">
                                                <div class="action">
                                                    <a href="{{ route('expense-recipients.edit', $recipient->id) }}">
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
                    <p>No supliers yet.</p>
                @endif
            </div>

            <div class="column">
                <div class="custom_form">
                    <div class="header">
                        <p>New Supplier</p>
                    </div>

                    <form action="{{ route('expense-recipients.store') }}" method="post">
                        @csrf

                        <div class="inputs">
                            <label for="name" class="required">Supplier's Name</label>
                            <input type="text" name="name" id="name" value="{{ old('name') }}">
                            <x-input-error field="name" />
                        </div>

                        <div class="inputs">
                            <label for="phone_number" class="required">Phone Number</label>
                            <input type="text" name="phone_number" id="phone_number" value="{{ old('phone_number') }}">
                            <x-input-error field="phone_number" />
                        </div>

                        <div class="inputs">
                            <label for="email">Email Address</label>
                            <input type="email" name="email" id="email" value="{{ old('email') }}">
                            <x-input-error field="email" />
                        </div>

                        <div class="inputs">
                            <label for="company_name">Company Name</label>
                            <input type="text" name="company_name" id="company_name" value="{{ old('company_name') }}">
                            <x-input-error field="company_name" />
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
