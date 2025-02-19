<x-authenticated-layout>
    <x-slot name="head">
        <x-searchable-select-header />
        <title>Assignment | Update</title>
    </x-slot>

    <section class="Assignments">
        <div class="custom_form">
            <div class="header">
                <div class="icon">
                    <a href="{{ route('assignments.index') }}">
                        <span class="fas fa-arrow-left"></span>
                    </a>
                </div>
                <p>Update Assignment</p>
            </div>

            <form action="{{ route('assignments.update', $assignment->id) }}" method="post" enctype="multipart/form-data">
                @csrf
                @method('patch')

                <div class="input_group">
                    <div class="inputs">
                        <label for="classroom_id" class="required">Classroom</label>
                        <select name="classroom_id" id="classroom_id">
                            <option value="">Select Classroom</option>
                            @foreach ($classrooms as $class)
                                <option value="{{ $class->id }}"
                                    {{ old('classroom_id', $assignment->classroom_id) == $class->id ? 'selected' : '' }}>{{ $class->name }}
                                </option>
                            @endforeach
                        </select>
                        <x-input-error field="classroom_id" />
                    </div>
    
                    <div class="inputs">
                        <label for="subject_id" class="required">Subject</label>
                        <select name="subject_id" id="subject_id">
                            <option value="">Select Subject</option>
                            @foreach ($subjects as $subject)
                                <option
                                    value="{{ $subject->id }}"{{ old('subject_id', $assignment->subject_id) == $subject->id ? 'selected' : '' }}>
                                    {{ $subject->name }}</option>
                            @endforeach
                        </select>
                        <x-input-error field="subject_id" />
                    </div>
                </div>
    
                <div class="input_group_3">
                    <div class="inputs">
                        <label for="date_issued" class="required">Date Issued</label>
                        <input type="date" name="date_issued" id="date_issued"
                            value="{{ old('date_issued', $assignment->date_issued->format('Y-m-d')) }}"
                            max="{{ now()->addMonths(2)->format('Y-m-d') }}">
                        <x-input-error field="date_issued" />
                    </div>
    
                    <div class="inputs">
                        <label for="deadline" class="required">Deadline</label>
                        <input type="date" name="deadline" id="deadline"
                            value="{{ old('deadline', $assignment->deadline->format('Y-m-d')) }}"
                            max="{{ now()->addMonths(2)->format('Y-m-d') }}">
                        <x-input-error field="deadline" />
                    </div>
    
                    <div class="inputs">
                        <label for="uploaded_assignment" class="required">Upload Assignment</label>
                        <input type="file" name="uploaded_assignment" id="uploaded_assignment">
                        <x-input-error field="uploaded_assignment" />
                    </div>
                </div>
    
                <div class="inputs">
                    <label for="description" class="required">Description</label>
                    <textarea name="description" id="editor_ckeditor" cols="30" rows="10" placeholder="Enter your description">{{ old('description', $assignment->description) }}</textarea>
                    <x-input-error field="description" />
                </div>

                <div class="buttons">
                    <button type="submit">Update Assignment</button>

                    <button type="button" class="btn_danger" onclick="deleteItem({{ $assignment->id }}, 'assignment');"
                        form="deleteForm_{{ $assignment->id }}">
                        <i class="fas fa-trash-alt delete"></i>
                        <span>Delete Assignment</span>                        
                    </button>
                </div>
            </form>

            <form id="deleteForm_{{ $assignment->id }}" action="{{ route('assignments.destroy', $assignment->id) }}" method="post"
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
