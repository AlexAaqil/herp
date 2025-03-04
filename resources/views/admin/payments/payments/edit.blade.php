<x-authenticated-layout>
    <x-slot name="head">
        <title>Payment | Update</title>
    </x-slot>

    <section class="Payments">
        <div class="custom_form">
            <div class="header">
                <div class="icon">
                    <a href="{{ route('payments.index') }}">
                        <span class="fas fa-arrow-left"></span>
                    </a>
                </div>
                <p>Update Paymet</p>
            </div>

            <form action="{{ route('payments.update', $payment->id) }}" method="post">
                @csrf
                @method('patch')

                <div class="input_group_3">
                    <div class="inputs">
                        <label for="classroom_category_id">Class</label>
                        <select name="classroom_category_id" id="classroom_category_id">
                            <option value="">Select Class</option>
                            @foreach ($classes as $class)
                                <option value="{{ $class->id }}" {{ old('classroom_category_id', $payment->classroom_category_id) == $class->id ? "selected" : "" }}>{{ $class->name }}</option>
                            @endforeach
                        </select>
                        <x-input-error field="classroom_category_id" />
                    </div>
    
                    <div class="inputs">
                        <label for="name">Title</label>
                        <input type="text" name="name" id="name" placeholder="E.g Tuition Fee"
                            value="{{ old('name', $payment->name) }}">
                        <x-input-error field="name" />
                    </div>
                </div>

                <div class="input_group_3">
                    <div class="inputs">
                        <label for="amount">Amount</label>
                        <input type="number" name="amount" id="amount" value="{{ old('amount', $payment->amount) }}">
                        <x-input-error field="amount" />
                    </div>
        
                    <div class="inputs">
                        <label for="year">Year</label>
                        <input type="number" name="year" id="year" min="1999" max="2050" value="{{ old('year', $payment->year) }}">
                        <x-input-error field="year" />
                    </div>
    
                    <div class="inputs">
                        <label for="term">Term</label>
                        <select name="term" id="term">
                            <option value="">Select Term</option>
                            <option value="1" {{ old('term', $payment->term) == "1" ? "selected" : "" }}>Term 1</option>
                            <option value="2" {{ old('term', $payment->term) == "2" ? "selected" : "" }}>Term 2</option>
                            <option value="3" {{ old('term', $payment->term) == "3" ? "selected" : "" }}>Term 3</option>
                        </select>
                        <x-input-error field="term" />
                    </div>
                </div>

                <div class="buttons">
                    <button type="submit">Update Paymet</button>

                    <button type="button" class="btn_danger" onclick="deleteItem({{ $payment->id }}, 'payment');"
                        form="deleteForm_{{ $payment->id }}">
                        <i class="fas fa-trash-alt delete"></i>
                        <span>Delete Paymet</span>                        
                    </button>
                </div>
            </form>

            <form id="deleteForm_{{ $payment->id }}" action="{{ route('payments.destroy', $payment->id) }}" method="post"
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
