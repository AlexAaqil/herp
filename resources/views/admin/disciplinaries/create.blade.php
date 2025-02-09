<x-authenticated-layout>
    <x-slot name="head">
        <x-searchable-select-header />
        <title>Disciplinary | New</title>
    </x-slot>

    <section class="XXX">
        <div class="custom_form">
            <div class="header">
                <div class="icon">
                    <a href="{{ route('disciplinaries.index') }}">
                        <span class="fas fa-arrow-left"></span>
                    </a>
                </div>
                <p>New Disciplinary</p>
            </div>

            <form action="{{ route('disciplinaries.store') }}" method="post">
                @csrf

                <div class="input_group_3">
                    <div class="inputs">
                        <label for="student_id">Student</label>
                        <select name="student_id" id="student_id" class="searchable_select">
                            <option value="">Select Student</option>
                            @foreach($students as $student)
                                <option value="{{ $student->id }}" {{ old('student_id') == $student->id ? 'selected' : '' }}>{{ $student->adm_no.' - '.$student->full_name }}</option>
                            @endforeach
                        </select>
                        <x-input-error field="student_id" />
                    </div>

                    <div class="inputs">
                        <label for="category">Category</label>
                        <div class="custom_radio_buttons">
                            <label>
                                <input class="option_radio" type="radio" name="category" id="minor"
                                    value="minor" {{ old('category', 'minor') == 'minor' ? 'checked' : '' }}>
                                <span>Minor</span>
                            </label>
    
                            <label>
                                <input class="option_radio" type="radio" name="category" id="major"
                                    value="major" {{ old('category') == 'major' ? 'checked' : '' }}>
                                <span>Major</span>
                            </label>
                        </div>
                        <x-input-error field="category" />
                    </div>
                </div>
                
                <div class="inputs">
                    <label for="comment">Comment</label>
                    <textarea name="comment" id="editor_ckeditor" cols="30" rows="10" placeholder="Enter your comment">{{ old('comment') }}</textarea>
                    <x-input-error field="comment" />
                </div>

                <button type="submit">Add Disciplinary</button>
            </form>
        </div>
    </section>

    <x-slot name="scripts">
        <x-searchable-select-js />
        <x-text-editor />
    </x-slot>
</x-authenticated-layout>
