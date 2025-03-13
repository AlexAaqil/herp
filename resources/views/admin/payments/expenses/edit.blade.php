<x-authenticated-layout>
    <x-slot name="head">
        <title>Expense | Update</title>
    </x-slot>

    <section class="Expenses">
        <div class="custom_form">
            <div class="header">
                <div class="icon">
                    <a href="{{ route('expenses.index') }}">
                        <span class="fas fa-arrow-left"></span>
                    </a>
                </div>
                <p>Update Expense</p>
            </div>

            <form action="{{ route('expenses.update', $expense->id) }}" method="post">
                @csrf
                @method('patch')

                <div class="input_group_3">
                    <div class="inputs">
                        <label for="expense_recipient_id" class="required">Recipent</label>
                        <select name="expense_recipient_id" id="expense_recipient_id">
                            <option value="">Select Recipient</option>
                            @foreach($recipients as $recipient)
                                <option value="{{ $recipient->id }}" {{ old('expense_recipient_id', $expense->expense_recipient_id) == $recipient->id ? 'selected' : '' }}>{{ $recipient->name }}</option>
                            @endforeach
                        </select>
                        <x-input-error field="expense_recipient_id" />
                    </div>

                    <div class="inputs">
                        <label for="expense_category_id" class="required">Category</label>
                        <select name="expense_category_id" id="expense_category_id">
                            <option value="">Select Category</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ old('expense_category_id', $expense->expense_category_id) == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                            @endforeach
                        </select>
                        <x-input-error field="expense_category_id" />
                    </div>

                    <div class="inputs">
                        <label for="date" class="required">Date</label>
                        <input type="date" name="date" id="date" value="{{ old('date', $expense->date->format('Y-m-d')) }}">
                        <x-input-error field="date" />
                    </div>
                </div>

                <div class="input_group_3">
                    <div class="inputs">
                        <label for="amount_paid" class="required">Amount</label>
                        <input type="number" name="amount_paid" id="amount_paid" value="{{ old('amount_paid', $expense->amount_paid) }}">
                        <x-input-error field="amount_paid" />
                    </div>

                    <div class="inputs">
                        <label for="payment_method" class="required">Paymet Method</label>
                        <div class="custom_radio_buttons">
                            @foreach(App\Models\Payments\Expense::PAYMENTMETHODS as $key)
                                <label>
                                    <input class="option_radio" 
                                        type="radio" 
                                        name="payment_method" 
                                        value="{{ $key }}"
                                        {{ old('payment_method', $expense->payment_method) == $key ? 'checked' : '' }}>
                                    <span>{{ ucfirst($key) }}</span>
                                </label>
                            @endforeach
                        </div>
                        <x-input-error field="payment_method" />
                    </div>

                    <div class="inputs">
                        <label for="reference_number">Reference Number</label>
                        <input type="text" name="reference_number" id="reference_number" value="{{ old('reference_number', $expense->reference_number) }}">
                        <x-input-error field="reference_number" />
                    </div>
                </div>

                 <div class="inputs">
                    <label for="description">Description</label>
                    <textarea name="description" id="editor_ckeditor" cols="30" rows="10" placeholder="Enter your description">{{ old('description', $expense->description) }}</textarea>
                    <x-input-error field="description" />
                </div>

                <div class="buttons">
                    <button type="submit">Update Expense</button>

                    <button type="button" class="btn_danger" onclick="deleteItem({{ $expense->id }}, 'expense');"
                        form="deleteForm_{{ $expense->id }}">
                        <i class="fas fa-trash-alt delete"></i>
                        <span>Delete Expense</span>                        
                    </button>
                </div>
            </form>

            <form id="deleteForm_{{ $expense->id }}" action="{{ route('expenses.destroy', $expense->id) }}" method="post"
                style="display: none;">
                @csrf
                @method('DELETE')
            </form>
        </div>
    </section>

    <x-slot name="scripts">
        <x-sweetalert />
        <x-text-editor />
    </x-slot>
</x-authenticated-layout>
