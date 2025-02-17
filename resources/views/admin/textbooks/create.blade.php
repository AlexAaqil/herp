<x-authenticated-layout>
    <x-slot name="head">
        <x-searchable-select-header />
        <title>Textbook | New</title>
    </x-slot>

    <section class="Textbooks">
        <div class="custom_form">
            <div class="header">
                <div class="icon">
                    <a href="{{ route('textbooks.index') }}">
                        <span class="fas fa-arrow-left"></span>
                    </a>
                </div>
                <p>New Textbook</p>
            </div>

            <form action="{{ route('textbooks.store') }}" method="post">
                @csrf

                <div class="input_group_3">
                    <div class="inputs">
                        <label for="student_id" class="required">Student</label>
                        <select name="student_id" id="student_id" class="searchable_select">
                            <option value="">Select Student</option>
                            @foreach($students as $student)
                                <option value="{{ $student->id }}" {{ old('student_id') == $student->id ? 'selected' : '' }}>{{ $student->adm_no.' - '.$student->first_name.' '.$student->last_name }}</option>
                            @endforeach
                        </select>
                        <x-input-error field="student_id" />
                    </div>

                    <div class="inputs">
                        <label for="book_name" class="required">Book Name</label>
                        <input type="text" name="book_name" id="book_name" placeholder="Book Name" value="{{ old('book_name') }}">
                        <x-input-error field="book_name" />
                    </div>
    
                    <div class="inputs">
                        <label for="book_number" class="required">Book Number</label>
                        <input type="text" name="book_number" id="book_number" placeholder="Book Number" value="{{ old('book_number') }}">
                        <x-input-error field="book_number" />
                    </div>
                </div>
    
                <div class="input_group_3">
                    <div class="inputs">
                        <label for="status" class="required">Status</label>
                        <div class="custom_radio_buttons">
                            @foreach(App\Models\Textbook::STATUSES as $status)
                                <label>
                                    <input class="option_radio" 
                                        type="radio" 
                                        name="status" 
                                        value="{{ $status }}"
                                        {{ old('status', 'issued') == $status ? 'checked' : '' }}>
                                    <span>{{ ucfirst($status) }}</span>
                                </label>
                            @endforeach
                        </div>
                        <x-input-error field="status" />
                    </div>

                    <div class="inputs">
                        <label for="date_issued">Date Issued</label>
                        <input type="date" name="date_issued" id="date_issued" value="{{ old('date_issued') }}">
                        <x-input-error field="date_issued" />
                    </div>
    
                    <div class="inputs">
                        <label for="date_returned">Date Returned</label>
                        <input type="date" name="date_returned" id="date_returned" value="{{ old('date_returned') }}">
                        <x-input-error field="date_returned" />
                    </div>
                </div>

                <button type="submit">Add Textbook</button>
            </form>
        </div>
    </section>

    <x-slot name="scripts">
        <x-searchable-select-js />
    </x-slot>
</x-authenticated-layout>
