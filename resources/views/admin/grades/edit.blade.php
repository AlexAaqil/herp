<x-authenticated-layout>
    <x-slot name="head">
        <title>Grade | Update</title>
    </x-slot>

    <section class="Grades">
        <div class="custom_form">
            <div class="header">
                <div class="icon">
                    <a href="{{ route('grades.index') }}">
                        <span class="fas fa-arrow-left"></span>
                    </a>
                </div>
                <p>Update Grade</p>
            </div>

            <form action="{{ route('grades.update', $grade->id) }}" method="post">
                @csrf
                @method('patch')

                <div class="input_group_3">
                    <div class="inputs">
                        <label for="grade" class="required">Grade</label>
                        <input type="text" name="grade" id="grade" placeholder="A-" value="{{ old('grade', $grade->grade) }}">
                        <x-input-error field="grade" />
                    </div>

                    <div class="inputs">
                        <label for="min_marks" class="required">Min Marks</label>
                        <input type="number" name="min_marks" id="min_marks" min="0" max="100" placeholder="0" value="{{ old('min_marks', $grade->min_marks) }}">
                        <x-input-error field="min_marks" />
                    </div>

                    <div class="inputs">
                        <label for="max_marks" class="required">Max Marks</label>
                        <input type="number" name="max_marks" id="max_marks" min="0" max="100" placeholder="100" value="{{ old('max_marks', $grade->max_marks) }}">
                        <x-input-error field="max_marks" />
                    </div>
                </div>

                <div class="buttons">
                    <button type="submit">Update Grade</button>

                    <button type="button" class="btn_danger" onclick="deleteItem({{ $grade->id }}, 'grade');"
                        form="deleteForm_{{ $grade->id }}">
                        <i class="fas fa-trash-alt delete"></i>
                        <span>Delete Grade</span>
                    </button>
                </div>
            </form>

            <form id="deleteForm_{{ $grade->id }}" action="{{ route('grades.destroy', $grade->id) }}" method="post"
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
