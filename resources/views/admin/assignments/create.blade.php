<x-authenticated-layout>
    <x-slot name="head">
        <x-searchable-select-header />
        <title>Assignment | New</title>
    </x-slot>

    <section class="Assignments">
        <div class="custom_form">
            <div class="header">
                <div class="icon">
                    <a href="{{ route('assignments.index') }}">
                        <span class="fas fa-arrow-left"></span>
                    </a>
                </div>
                <p>New Assignment</p>
            </div>

            <form action="{{ route('assignments.store') }}" method="post" enctype="multipart/form-data">
                @csrf

                <div class="input_group">
                    <div class="inputs">
                        <label for="classroom_id" class="required">Classroom</label>
                        <select name="classroom_id" id="classroom_id">
                            <option value="">Select Classroom</option>
                            @foreach ($classrooms as $class)
                                <option value="{{ $class->id }}"
                                    {{ old('classroom_id') == $class->id ? 'selected' : '' }}>{{ $class->name }}
                                </option>
                            @endforeach
                        </select>
                        <span class="inline_alert">{{ $errors->first('classroom_id') }}</span>
                    </div>
    
                    <div class="inputs">
                        <label for="subject_id" class="required">Subject</label>
                        <select name="subject_id" id="subject_id">
                            <option value="">Select Subject</option>
                            @foreach ($subjects as $subject)
                                <option
                                    value="{{ $subject->id }}"{{ old('subject_id') == $subject->id ? 'selected' : '' }}>
                                    {{ $subject->name }}</option>
                            @endforeach
                        </select>
                        <span class="inline_alert">{{ $errors->first('subject_id') }}</span>
                    </div>
                </div>
    
                <div class="input_group_3">
                    <div class="inputs">
                        <label for="date_issued" class="required">Date Issued</label>
                        <input type="date" name="date_issued" id="date_issued"
                            value="{{ old('date_issued', now()->format('Y-m-d')) }}"
                            max="{{ now()->addMonths(2)->format('Y-m-d') }}">
                        <span class="inline_alert">{{ $errors->first('date_issued') }}</span>
                    </div>
    
                    <div class="inputs">
                        <label for="deadline" class="required">Deadline</label>
                        <input type="date" name="deadline" id="deadline"
                            value="{{ old('deadline') }}"
                            max="{{ now()->addMonths(2)->format('Y-m-d') }}">
                        <span class="inline_alert">{{ $errors->first('deadline') }}</span>
                    </div>
    
                    <div class="inputs">
                        <label for="uploaded_file" class="required">Upload Assignment</label>
                        <input type="file" name="uploaded_file" id="uploaded_file">
                        <span class="inline_alert">{{ $errors->first('uploaded_file') }}</span>
                    </div>
                </div>
    
                <div class="inputs">
                    <label for="description" class="required">Description</label>
                    <textarea name="description" id="editor_ckeditor" cols="30" rows="10" placeholder="Enter your description">{{ old('description') }}</textarea>
                    <span class="inline_alert">{{ $errors->first('description') }}</span>
                </div>

                <button type="submit">Add Assignment</button>
            </form>
        </div>
    </section>

    <x-slot name="scripts">
        <x-searchable-select-js />
        <x-text-editor />
    </x-slot>
</x-authenticated-layout>
