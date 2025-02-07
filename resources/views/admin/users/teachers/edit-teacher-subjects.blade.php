<x-authenticated-layout>
    <x-slot name="head">
        <title>Teacher Subjects | Update</title>
    </x-slot>

    <section class="Users">
        <div class="custom_form">
            <div class="header">
                <div class="icon">
                    <a href="{{ route('teachers.index') }}">
                        <span class="fas fa-arrow-left"></span>
                    </a>
                </div>
                <p>Update Teacher Subjects</p>
            </div>

            <form action="{{ route('teacher-subjects.update', $teacher_subject->id) }}" method="post">
                @csrf
                @method('patch')

                <p>{{ $teacher_subject->teacher->full_name }}</p>
            
                <div class="input_group">
                    <div class="inputs">
                        <label for="classroom_id">Class</label>
                        <select name="classroom_id" id="classroom_id">
                            <option value="">Select Class</option>
                            @foreach ($classrooms as $classroom)
                                <option value="{{ $classroom->id }}" {{ old('classroom_id', $teacher_subject->classroom_id) == $classroom->id ? 'selected' : '' }}>{{ $classroom->name }}</option>
                            @endforeach
                        </select>
                        <x-input-error field="classroom_id" />
                    </div>

                    <div class="inputs">
                        <label for="subject_id">Subject</label>
                        <select name="subject_id" id="subject_id">
                            <option value="">Select Subject</option>
                            @foreach ($subjects as $subject)
                                <option value="{{ $subject->id }}" {{ old('subject_id', $teacher_subject->subject_id) == $subject->id ? 'selected' : '' }}>{{ $subject->name }}</option>
                            @endforeach
                        </select>
                        <x-input-error field="subject_id" />
                    </div>
                </div>

                <div class="buttons">
                    <button type="submit">Update Subject Assignment</button>

                    <button type="button" class="btn_danger" onclick="deleteItem({{ $teacher_subject->id }}, 'teacher subject');"
                        form="deleteForm_{{ $teacher_subject->id }}">
                        <i class="fas fa-trash-alt delete"></i>
                        <span>Delete Subject Assignment</span>
                    </button>
                </div>
            </form>

            <form id="deleteForm_{{ $teacher_subject->id }}" action="{{ route('teacher-subjects.destroy', $teacher_subject->id) }}" method="post"
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
