<x-authenticated-layout>
    <x-slot name="head">
        <title>Exam | Update</title>
    </x-slot>

    <section class="Exams">
        <div class="custom_form">
            <div class="header">
                <div class="icon">
                    <a href="{{ route('exams.index') }}">
                        <span class="fas fa-arrow-left"></span>
                    </a>
                </div>
                <p>Update Exam</p>
            </div>

            <form action="{{ route('exams.update', $exam->id) }}" method="post">
                @csrf
                @method('patch')

                <div class="input_group_3">
                    <div class="inputs">
                        <label for="name">Name</label>
                        <input type="text" name="name" id="name" placeholder="name" value="{{ old('name', $exam->name) }}">
                        <x-input-error field="name" />
                    </div>

                    <div class="inputs">
                        <label for="year">Year</label>
                        <input type="number" name="year" id="year" value="{{ old('year', $exam->year) }}" min="1995" max="2050">
                        <span class="inline_alert">{{ $errors->first('year') }}</span>
                    </div>
    
                    <div class="inputs">
                        <label for="term">Term</label>
                        <select name="term" id="term">
                            <option value="">Select Term</option>
                            <option value="1" {{ old('term', $exam->term) == "1" ? "selected" : "" }}>Term 1</option>
                            <option value="2" {{ old('term', $exam->term) == "2" ? "selected" : "" }}>Term 2</option>
                            <option value="3" {{ old('term', $exam->term) == "3" ? "selected" : "" }}>Term 3</option>
                        </select>
                        <span class="inline_alert">{{ $errors->first('term') }}</span>
                    </div>
                </div>

                <div class="buttons">
                    <button type="submit">Update Exam</button>

                    <button type="button" class="btn_danger" onclick="deleteItem({{ $exam->id }}, 'exam');"
                        form="deleteForm_{{ $exam->id }}">
                        <i class="fas fa-trash-alt delete"></i>
                        <span>Delete Exam</span>                        
                    </button>
                </div>
            </form>

            <form id="deleteForm_{{ $exam->id }}" action="{{ route('exams.destroy', $exam->id) }}" method="post"
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
