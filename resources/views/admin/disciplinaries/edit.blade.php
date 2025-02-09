<x-authenticated-layout>
    <x-slot name="head">
        <x-searchable-select-header />
        <title>Disciplinary | Update</title>
    </x-slot>

    <section class="Disciplinaries">
        <div class="custom_form">
            <div class="header">
                <div class="icon">
                    <a href="{{ route('disciplinaries.index') }}">
                        <span class="fas fa-arrow-left"></span>
                    </a>
                </div>
                <p>Update Disciplinary</p>
            </div>

            <form action="{{ route('disciplinaries.update', $disciplinary->id) }}" method="post">
                @csrf
                @method('patch')

                <div class="input_group">
                    <div class="inputs">
                        <label for="student_id">Student</label>
                        <select name="student_id" id="student_id" class="searchable_select">
                            <option value="">Select Student</option>
                            @foreach ($students as $student)
                                <option value="{{ $student->id }}"
                                    {{ old('student_id', $disciplinary->student_id) == $student->id ? 'selected' : '' }}>
                                    {{ $student->adm_no . ' - ' . $student->full_name }}
                                </option>
                            @endforeach
                        </select>
                        <span class="inline_alert">{{ $errors->first('student_id') }}</span>
                    </div>
    
                    <div class="inputs">
                        <label for="category">Category</label>
                        <div class="custom_radio_buttons">
                            <label>
                                <input class="option_radio" type="radio" name="category" id="minor" value="minor"
                                    {{ old('category', $disciplinary->category) == 'minor' ? 'checked' : '' }}>
                                <span>Minor</span>
                            </label>
    
                            <label>
                                <input class="option_radio" type="radio" name="category" id="major" value="major"
                                    {{ old('category', $disciplinary->category) == 'major' ? 'checked' : '' }}>
                                <span>Major</span>
                            </label>
                        </div>
                        <span class="inline_alert">{{ $errors->first('category') }}</span>
                    </div>
                </div>
    
                <div class="inputs">
                    <label for="comment">Comment</label>
                    <textarea name="comment" id="editor_ckeditor" cols="30" rows="10" placeholder="Enter your comment">{{ old('comment', $disciplinary->comment) }}</textarea>
                    <span class="inline_alert">{{ $errors->first('comment') }}</span>
                </div>

                <div class="buttons">
                    <button type="submit">Update Disciplinary</button>

                    <button type="button" class="btn_danger" onclick="deleteItem({{ $disciplinary->id }}, 'disciplinary');"
                        form="deleteForm_{{ $disciplinary->id }}">
                        <i class="fas fa-trash-alt delete"></i>
                        <span>Delete Disciplinary</span>
                    </button>
                </div>
            </form>

            <form id="deleteForm_{{ $disciplinary->id }}" action="{{ route('disciplinaries.destroy', $disciplinary->id) }}" method="post"
                style="display: none;">
                @csrf
                @method('DELETE')
            </form>
        </div>
    </section>

    <x-slot name="scripts">
        <x-sweetalert />
        <x-searchable-select-js />
        <x-text-editor />
    </x-slot>
</x-authenticated-layout>
