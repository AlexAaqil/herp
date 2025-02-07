<x-authenticated-layout>
    <x-slot name="head">
        <title>Grade | New</title>
    </x-slot>

    <section class="Grades">
        <div class="custom_form">
            <div class="header">
                <div class="icon">
                    <a href="{{ route('grades.index') }}">
                        <span class="fas fa-arrow-left"></span>
                    </a>
                </div>
                <p>New Grade</p>
            </div>

            <form action="{{ route('grades.store') }}" method="post">
                @csrf

                <div class="input_group_3">
                    <div class="inputs">
                        <label for="grade" class="required">Grade</label>
                        <input type="text" name="grade" id="grade" placeholder="A-" value="{{ old('grade') }}">
                        <x-input-error field="grade" />
                    </div>

                    <div class="inputs">
                        <label for="min_marks" class="required">Min Marks</label>
                        <input type="number" name="min_marks" id="min_marks" min="0" max="100" placeholder="0" value="{{ old('min_marks') }}">
                        <x-input-error field="min_marks" />
                    </div>

                    <div class="inputs">
                        <label for="max_marks" class="required">Max Marks</label>
                        <input type="number" name="max_marks" id="max_marks" min="0" max="100" placeholder="100" value="{{ old('max_marks') }}">
                        <x-input-error field="max_marks" />
                    </div>
                </div>

                <button type="submit">Add Grade</button>
            </form>
        </div>
    </section>
</x-authenticated-layout>
