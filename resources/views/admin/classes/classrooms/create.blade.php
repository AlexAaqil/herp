<x-authenticated-layout>
    <x-slot name="head">
        <title>Classroom | New</title>
    </x-slot>

    <section class="Classrooms">
        <div class="custom_form">
            <div class="header">
                <div class="icon">
                    <a href="{{ route('classrooms.index') }}">
                        <span class="fas fa-arrow-left"></span>
                    </a>
                </div>
                <p>New Classroom</p>
            </div>

            <form action="{{ route('classrooms.store') }}" method="post">
                @csrf

                <div class="input_group_3">
                    <div class="inputs">
                        <label for="classroom_category_id" class="required">Class Category</label>
                        <select name="classroom_category_id" id="classroom_category_id">
                            <option value="">Select Class Category</option>
                            @foreach ($classroom_categories as $category)
                                <option value="{{ $category->id }}" {{ old('classroom_category_id') == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                            @endforeach
                        </select>
                        <x-input-error field="classroom_category_id" />
                    </div>

                    <div class="inputs">
                        <label for="name" class="required">Classroom Name</label>
                        <input type="text" name="name" id="name" placeholder="1 South" value="{{ old('name') }}">
                        <x-input-error field="name" />
                    </div>

                    <div class="inputs">
                        <label for="class_teacher_id">Class Teacher</label>
                        <select name="class_teacher_id" id="class_teacher_id">
                            <option value="">Select Class Teacher</option>
                            @foreach($teachers as $teacher)
                                <option value="{{ $teacher->id }}" {{ old('class_teacher_id') == $teacher->id ? 'selected' : '' }}>{{ $teacher->full_name }} {{ $teacher->emp_code ? ' - '.$teacher->emp_code : ' - emp code N/A' }}</option>
                            @endforeach
                        </select>
                        <x-input-error field="class_teacher_id" />
                    </div>
                </div>

                <button type="submit">Add Classroom</button>
            </form>
        </div>

        <div class="custom_form">
            <div class="header">
                <div class="icon">
                    <a href="{{ route('classrooms.index') }}">
                        <span class="fas fa-arrow-left"></span>
                    </a>
                </div>
                <p>New Classroom Category</p>
            </div>

            <form action="{{ route('classroom-categories.store') }}" method="post">
                @csrf

                <div class="input_group_3">
                    <div class="inputs">
                        <label for="classroom_category_name" class="required">Classroom Category Name</label>
                        <input type="text" name="classroom_category_name" id="classroom_category_name" placeholder="Form 1" value="{{ old('classroom_category_name') }}">
                        <x-input-error field="classroom_category_name" />
                    </div>
                </div>

                <button type="submit">Add Classroom Category</button>
            </form>
        </div>
    </section>
</x-authenticated-layout>
