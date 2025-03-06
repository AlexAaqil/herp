<x-authenticated-layout>
    <x-slot name="head">
        <title>Expense Recipient | Update</title>
    </x-slot>

    <section class="Expenses">
        <div class="custom_form">
            <div class="header">
                <div class="icon">
                    <a href="{{ route('expense-recipients.index') }}">
                        <span class="fas fa-arrow-left"></span>
                    </a>
                </div>
                <p>Update Supplier</p>
            </div>

            <form action="{{ route('expense-recipients.update', $expense_recipient->id) }}" method="post">
                @csrf
                @method('patch')

                <div class="input_group">
                    <div class="inputs">
                        <label for="name" class="required">Supplier's Name</label>
                        <input type="text" name="name" id="name" value="{{ old('name', $expense_recipient->name) }}">
                        <x-input-error field="name" />
                    </div>
    
                    <div class="inputs">
                        <label for="phone_number" class="required">Phone Number</label>
                        <input type="text" name="phone_number" id="phone_number" value="{{ old('phone_number', $expense_recipient->phone_number) }}">
                        <x-input-error field="phone_number" />
                    </div>
                </div>

                <div class="input_group">
                    <div class="inputs">
                        <label for="email">Email Address</label>
                        <input type="email" name="email" id="email" value="{{ old('email', $expense_recipient->email) }}">
                        <x-input-error field="email" />
                    </div>
    
                    <div class="inputs">
                        <label for="company_name">Company Name</label>
                        <input type="text" name="company_name" id="company_name" value="{{ old('company_name', $expense_recipient->company_name) }}">
                        <x-input-error field="company_name" />
                    </div>
                </div>

                <div class="buttons">
                    <button type="submit">Update Supplier</button>

                    <button type="button" class="btn_danger" onclick="deleteItem({{ $expense_recipient->id }}, 'supplier');"
                        form="deleteForm_{{ $expense_recipient->id }}">
                        <i class="fas fa-trash-alt delete"></i>
                        <span>Delete Supplier</span>                        
                    </button>
                </div>
            </form>

            <form id="deleteForm_{{ $expense_recipient->id }}" action="{{ route('expense-recipients.destroy', $expense_recipient->id) }}" method="post"
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
