<x-authenticated-layout>
    <x-slot name="head">
        <title>Classroom | Edit</title>
    </x-slot>

    <section class="Classrooms">
        <div class="custom_form">
            <div class="header">
                <div class="icon">
                    <a href="{{ route('classrooms.index') }}">
                        <span class="fas fa-arrow-left"></span>
                    </a>
                </div>
                <p>Update Classroom</p>
            </div>

            <form action="{{ route('classrooms.update', $classroom->id) }}" method="post">
                @csrf
                @method('patch')

                <div class="input_group_3">
                    <div class="inputs">
                        <label for="name">Classroom Name</label>
                        <input type="text" name="name" id="name" placeholder="1 South" value="{{ old('name', $classroom->name) }}">
                        <x-input-error field="name" />
                    </div>

                    <div class="inputs">
                        <label for="classroom_category_id">Class Category</label>
                        <select name="classroom_category_id" id="classroom_category_id">
                            <option value="">Select Class Category</option>
                            @foreach ($classroom_categories as $category)
                                <option value="{{ $category->id }}" {{ old('classroom_category_id', $classroom->classroom_category_id) == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                            @endforeach
                        </select>
                        <x-input-error field="classroom_category_id" />
                    </div>

                    <div class="inputs">
                        <label for="class_teacher_id">Class Teacher</label>
                        <select name="class_teacher_id" id="class_teacher_id">
                            <option value="">Select Class Teacher</option>
                            @foreach($teachers as $teacher)
                                <option value="{{ $teacher->id }}" {{ old('class_teacher_id', $classroom->class_teacher_id) == $teacher->id ? 'selected' : '' }}>{{ $teacher->full_name }} {{ $teacher->emp_code ? ' - '.$teacher->emp_code : ' - emp code N/A' }}</option>
                            @endforeach
                        </select>
                        <x-input-error field="class_teacher_id" />
                    </div>
                </div>

                <div class="buttons">
                    <button type="submit">Update Classroom</button>
                    
                    <button type="button" class="btn_danger" onclick="deleteItem({{ $classroom->id }}, 'classroom');"
                        form="deleteForm_{{ $classroom->id }}">
                        <i class="fas fa-trash-alt delete"></i>
                        <span>Delete Class</span>
                    </button>
                </div>
            </form>

            <form id="deleteForm_{{ $classroom->id }}" action="{{ route('classrooms.destroy', $classroom->id) }}" method="post"
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